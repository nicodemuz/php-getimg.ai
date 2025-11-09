<?php

declare(strict_types=1);

namespace Nicodemuz\PhpGetImgAi\Request;

use InvalidArgumentException;

class InpaintingRequest
{
    private string $prompt;
    private string $image;
    private string $maskImage;
    private string $family;
    private string $model;
    private ?string $negativePrompt;
    private ?string $prompt2;
    private ?string $negativePrompt2;
    private float $strength;
    private int $width;
    private int $height;
    private int $steps;
    private float $guidance;
    private ?int $seed;
    private string $outputFormat;
    private string $responseFormat;

    public function __construct(
        string $prompt,
        string $image,
        string $maskImage,
        string $model = 'stable-diffusion-xl-v1-0',
        ?string $negativePrompt = null,
        ?string $prompt2 = null,
        ?string $negativePrompt2 = null,
        float $strength = 0.8,
        int $width = 1024,
        int $height = 1024,
        int $steps = 30,
        float $guidance = 7.5,
        ?int $seed = null,
        string $outputFormat = 'jpeg',
        string $responseFormat = 'b64',
    ) {
        $this->setPrompt($prompt);
        $this->setImage($image);
        $this->setMaskImage($maskImage);
        $this->setModel($model);
        $this->setNegativePrompt($negativePrompt);
        $this->setPrompt2($prompt2);
        $this->setNegativePrompt2($negativePrompt2);
        $this->setStrength($strength);
        $this->setWidth($width);
        $this->setHeight($height);
        $this->setSteps($steps);
        $this->setGuidance($guidance);
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

    public function setNegativePrompt(?string $negativePrompt): void
    {
        if ($negativePrompt && strlen($negativePrompt) > 2048) {
            throw new InvalidArgumentException('Negative prompt length must be ≤ 2048 characters.');
        }
        $this->negativePrompt = $negativePrompt;
    }

    public function setPrompt2(?string $prompt2): void
    {
        if ($prompt2 && strlen($prompt2) > 2048) {
            throw new InvalidArgumentException('Prompt2 length must be ≤ 2048 characters.');
        }
        $this->prompt2 = $prompt2;
    }

    public function setNegativePrompt2(?string $negativePrompt2): void
    {
        if ($negativePrompt2 && strlen($negativePrompt2) > 2048) {
            throw new InvalidArgumentException('Negative prompt2 length must be ≤ 2048 characters.');
        }
        $this->negativePrompt2 = $negativePrompt2;
    }

    public function setImage(string $filePath): void
    {
        $imageData = file_get_contents($filePath);
        $this->image = base64_encode($imageData);
    }

    public function setMaskImage(string $filePath): void
    {
        $imageData = file_get_contents($filePath);
        $this->maskImage = base64_encode($imageData);
    }

    public function setModel(string $model): void
    {
        $family = $this->getModelFamilies()[$model] ?? null;

        $this->family = $family;

        if (!$family) {
            throw new InvalidArgumentException('Unsupported/untested model.');
        }
        $this->model = $model;
    }

    public function setFamily(string $family): void
    {
        $families = $this->getModelFamilies();

        if (!in_array($family, $families, true)) {
            throw new InvalidArgumentException('Unsupported/untested family.');
        }
        $this->family = $family;
    }

    private function getModelFamilies(): array
    {
        return [
            'stable-diffusion-xl-v1-0' => 'stable-diffusion-xl',
            'realistic-vision-v5-1-inpainting' => 'stable-diffusion',
            'stable-diffusion-v1-5-inpainting' => 'stable-diffusion',
            'realistic-vision-v1-3-inpainting' => 'stable-diffusion',
        ];
    }

    public function setStrength(float $strength): void
    {
        if ($strength < 0 || $strength > 1) {
            throw new InvalidArgumentException('Strength must be between 0 and 1.');
        }
        $this->strength = $strength;
    }

    public function setWidth(int $width): void
    {
        if ($width < 256 || $width > 1536) {
            throw new InvalidArgumentException('Width must be between 256 and 1536.');
        }
        $this->width = $width;
    }

    public function setHeight(int $height): void
    {
        if ($height < 256 || $height > 1536) {
            throw new InvalidArgumentException('Height must be between 256 and 1536.');
        }
        $this->height = $height;
    }

    public function setSteps(int $steps): void
    {
        if ($steps < 1 || $steps > 100) {
            throw new InvalidArgumentException('Steps must be between 1 and 6.');
        }
        $this->steps = $steps;
    }

    public function setGuidance(float $guidance): void
    {
        if ($guidance < 0 || $guidance > 20) {
            throw new InvalidArgumentException('Guidance must be between 0 and 20.');
        }
        $this->guidance = $guidance;
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
            'image' => $this->image,
            'mask_image' => $this->maskImage,
            'model' => $this->model,
            'prompt' => $this->prompt,
            'negative_prompt' => $this->negativePrompt,
            'prompt2' => $this->prompt2,
            'negative_prompt2' => $this->negativePrompt2,
            'strength' => $this->strength,
            'width' => $this->width,
            'height' => $this->height,
            'steps' => $this->steps,
            'guidance' => $this->guidance,
            'seed' => $this->seed,
            'output_format' => $this->outputFormat,
            'response_format' => $this->responseFormat,
        ], function (float|int|string|null $value): bool {
            // Keep all values except null
            return $value !== null;
        });
    }

    public function getFamily(): string
    {
        return $this->family;
    }
}
