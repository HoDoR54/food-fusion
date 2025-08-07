<?php

namespace App\DTO\Responses;

class UserSimpleResponse
{
    public string $id;
    public string $name;
    public string $email;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(
        string $id,
        string $name,
        string $email,
        string $createdAt,
        string $updatedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
