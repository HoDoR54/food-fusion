<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepo extends AbstractRepo
{
    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }

    public function findOrCreateByNameAndType(string $name, string $type): Tag
    {
        return $this->model->firstOrCreate(
            ['name' => strtolower(trim($name))],
            ['type' => $type]
        );
    }

    public function getByType(string $type): array
    {
        return $this->model->where('type', $type)
            ->distinct()
            ->pluck('name')
            ->toArray();
    }
}
