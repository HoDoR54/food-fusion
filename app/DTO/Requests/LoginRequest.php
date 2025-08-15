<?php

namespace App\DTO\Requests;

class LoginRequest
{
    private string $identifier;
    private string $password;

    public function __construct(string $identifier, string $password)
    {
        $this->identifier = $identifier;
        $this->password = $password;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isEmail(): bool
    {
        return filter_var($this->identifier, FILTER_VALIDATE_EMAIL) !== false;
    }
}