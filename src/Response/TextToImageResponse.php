<?php

declare(strict_types=1);

namespace Nicodemuz\PhpGetImgAi\Response;

readonly class TextToImageResponse
{
    public function __construct(
        private string $url,
        private int $seed,
        private float $cost
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['url'],
            $data['seed'],
            $data['cost'],
        );
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getSeed(): int
    {
        return $this->seed;
    }

    public function getCost(): float
    {
        return $this->cost;
    }
}