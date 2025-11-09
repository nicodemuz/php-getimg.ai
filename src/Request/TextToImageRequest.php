<?php

declare(strict_types=1);

namespace Nicodemuz\PhpGetImgAi\Request;

use InvalidArgumentException;

class TextToImageRequest
{
    private string $prompt;
    private string $model;
    private int $width;
    private int $height;
    private int $steps;
    private ?int $seed;
    private string $outputFormat;
    private string $responseFormat;

    public function __construct(
        string $prompt,
        string $model = 'flux-schnell',
        int $width = 1024,
        int $height = 1024,
        int $steps = 4,
        ?int $seed = null,
        string $outputFormat = 'jpeg',
        string $responseFormat = 'b64',
    ) {
        $this->setPrompt($prompt);
        $this->setModel($model);
        $this->setWidth($width);
        $this->setHeight($height);
        $this->setSteps($steps);
        $this->setSeed($seed);
        $this->setOutputFormat($outputFormat);
        $this->setResponseFormat($responseFormat);
    }

    public function setPrompt(string $prompt): void
    {
        if (strlen($prompt) > 2048) {
            throw new InvalidArgumentException('Prompt length must be ≤ 2048 characters.');
        }
        $this->prompt = $prompt;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function setWidth(int $width): void
    {
        if ($width < 256 || $width > 1280) {
            throw new InvalidArgumentException('Width must be between 256 and 1280.');
        }
        $this->width = $width;
    }

    public function setHeight(int $height): void
    {
        if ($height < 256 || $height > 1280) {
            throw new InvalidArgumentException('Height must be between 256 and 1280.');
        }
        $this->height = $height;
    }

    public function setSteps(int $steps): void
    {
        if ($steps < 1 || $steps > 6) {
            throw new InvalidArgumentException('Steps must be between 1 and 6.');
        }
        $this->steps = $steps;
    }

    public function setSeed(?int $seed): void
    {
        if ($seed !== null && ($seed < 1 || $seed > 2147483647)) {
            throw new InvalidArgumentException('Seed must be between 1 and 2147483647.');
        }
        $this->seed = $seed;
    }

    public function setOutputFormat(string $outputFormat): void
    {
        if (!in_array($outputFormat, ['jpeg', 'png'], true)) {
            throw new InvalidArgumentException('Output format must be either jpeg or png.');
        }
        $this->outputFormat = $outputFormat;
    }

    public function setResponseFormat(string $responseFormat): void
    {
        if (!in_array($responseFormat, ['url', 'b64'], true)) {
            throw new InvalidArgumentException('Response format must be either url or b64.');
        }
        $this->responseFormat = $responseFormat;
    }

    public function toArray(): array
    {
        return array_filter([
            'prompt' => $this->prompt,
            'width' => $this->width,
            'height' => $this->height,
            'steps' => $this->steps,
            'seed' => $this->seed,
            'output_format' => $this->outputFormat,
            'response_format' => $this->responseFormat,
        ]);
    }

    public function getModel(): string
    {
        return $this->model;
    }
}
