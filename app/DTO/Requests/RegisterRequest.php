<?php

namespace App\DTO\Requests;

use App\Enums\MasteryLevel;

class RegisterRequest
{
    private string $firstName;
    private string $lastName;
    private string $username;
    private string $email;
    private string $phoneNumber;
    private string $password;
    private MasteryLevel $masteryLevel;

    public function __construct(string $firstName, string $lastName, string $username, string $email, string $phoneNumber, string $password, string $masteryLevel)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->email = $email;
        $this->masteryLevel = MasteryLevel::toEnum($masteryLevel);
        $this->phoneNumber = $phoneNumber;
        $this->password = $password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMasteryLevel(): MasteryLevel
    {
        return $this->masteryLevel;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}