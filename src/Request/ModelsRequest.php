<?php

declare(strict_types=1);

namespace Nicodemuz\PhpGetImgAi\Request;

class ModelsRequest
{
    private ?string $family;
    private ?string $pipeline;

    public function __construct(?string $family = null, ?string $pipeline = null)
    {
        $this->family = $family;
        $this->pipeline = $pipeline;
    }

    public function toArray(): array
    {
        return array_filter([
            'family' => $this->family,
            'pipeline' => $this->pipeline,
        ]);
    }
}
