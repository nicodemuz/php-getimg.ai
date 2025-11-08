<?php

declare(strict_types=1);

namespace Nicodemuz\PhpGetImgAi;

use Exception;
use Nicodemuz\PhpGetImgAi\Dto\Model;
use Nicodemuz\PhpGetImgAi\Request\InpaintingRequest;
use Nicodemuz\PhpGetImgAi\Request\ModelsRequest;
use Nicodemuz\PhpGetImgAi\Request\TextToImageRequest;
use Nicodemuz\PhpGetImgAi\Response\ImageResponse;
use Nicodemuz\PhpGetImgAi\Response\ModelsResponse;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GetImgAiClient
{
    private string $baseUrl = 'https://api.getimg.ai/v1';

    public function __construct(
        private readonly string $apiKey,
        private readonly ClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory
    ) {
    }

    public function getModels(ModelsRequest $request): ModelsResponse
    {
        $response = $this->request('GET', '/models', $request->toArray());

        return new ModelsResponse($response);
    }

    public function getModel(string $id): Model
    {
        $response = $this->request('GET', '/models/' . $id);

        return Model::fromArray($response);
    }

    public function textToImage(TextToImageRequest $request): ImageResponse
    {
        $response = $this->request('POST', '/' . $request->getModel() . '/text-to-image/', $request->toArray());

        return ImageResponse::fromArray($response);
    }

    public function inpaint(InpaintingRequest $request): ImageResponse
    {
        $response = $this->request('POST', '/' . $request->getFamily() . '/inpaint', $request->toArray());

        return ImageResponse::fromArray($response);
    }

    private function request(string $method, string $endpoint, ?array $params = null): array
    {
        $url = $this->baseUrl . $endpoint;

        if (!empty($params) && 'GET' === $method) {
            $url .= '?' . http_build_query($params);
        }

        $request = $this->requestFactory->createRequest($method, $url)
            ->withHeader('Authorization', 'Bearer ' . $this->apiKey)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json')
        ;

        if (!empty($params) && 'GET' !== $method) {
            $stream = $this->streamFactory->createStream(json_encode($params));
            $request = $request->withBody($stream);
        }

        $response = $this->httpClient->sendRequest($request);

        return $this->handleResponse($response);
    }

    private function handleResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        $body = (string) $response->getBody();

        if ($statusCode < 200 || $statusCode >= 300) {
            throw new Exception(sprintf('API request failed with status code %s: %s', $statusCode, $body));
        }

        return json_decode($body, true);
    }
}
