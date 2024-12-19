<?php

declare(strict_types=1);

namespace Nicodemuz\PhpGetImgAi\Dto;

use DateTimeImmutable;

class Model
{
    private string $id;
    private string $name;
    private string $family;
    private array $pipelines;
    private ?int $baseResolutionWidth;
    private ?int $baseResolutionHeight;
    private float $price;
    private string $authorUrl;
    private string $licenseUrl;
    private DateTimeImmutable $created;

    public function __construct(
        string $id,
        string $name,
        string $family,
        array $pipelines,
        int $baseResolutionWidth,
        int $baseResolutionHeight,
        float $price,
        string $authorUrl,
        string $licenseUrl,
        DateTimeImmutable $created,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->family = $family;
        $this->pipelines = $pipelines;
        $this->baseResolutionWidth = $baseResolutionWidth;
        $this->baseResolutionHeight = $baseResolutionHeight;
        $this->price = $price;
        $this->authorUrl = $authorUrl;
        $this->licenseUrl = $licenseUrl;
        $this->created = $created;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['family'],
            $data['pipelines'],
            $data['base_resolution']['width'] ?? 0,
            $data['base_resolution']['height'] ?? 0,
            $data['price'],
            $data['author_url'],
            $data['license_url'],
            new DateTimeImmutable($data['created'])
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFamily(): string
    {
        return $this->family;
    }

    public function getPipelines(): array
    {
        return $this->pipelines;
    }

    public function getBaseResolutionWidth(): int
    {
        return $this->baseResolutionWidth;
    }

    public function getBaseResolutionHeight(): int
    {
        return $this->baseResolutionHeight;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getAuthorUrl(): string
    {
        return $this->authorUrl;
    }

    public function getLicenseUrl(): string
    {
        return $this->licenseUrl;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }
}
