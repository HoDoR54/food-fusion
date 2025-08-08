<?php

namespace App\DTO\Responses;

use App\Models\User;

class UserSimpleResponse
{
    private string $id;
    private string $name;
    private string $email;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(
        User $user
    ) {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->createdAt = $user->created_at;
        $this->updatedAt = $user->updated_at;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
