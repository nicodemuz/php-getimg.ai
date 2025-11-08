<?php

declare(strict_types=1);

namespace Nicodemuz\PhpGetImgAi\Request;

readonly class ModelsRequest
{
    public function __construct(
        private ?string $family = null,
        private ?string $pipeline = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'family' => $this->family,
            'pipeline' => $this->pipeline,
        ]);
    }
}
