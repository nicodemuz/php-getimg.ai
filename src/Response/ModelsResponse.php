<?php

declare(strict_types=1);

namespace Nicodemuz\PhpGetImgAi\Response;

use Nicodemuz\PhpGetImgAi\Dto\Model;

class ModelsResponse
{
    private array $models = [];

    public function __construct(array $data)
    {
        foreach ($data as $model) {
            $this->models[] = Model::fromArray($model);
        }
    }

    public function getModels(): array
    {
        return $this->models;
    }
}
