<?php

namespace App\DTO\Requests;

use App\Enums\MasteryLevel;

class RegisterRequest
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phoneNumber;
    private string $password;
    private MasteryLevel $masteryLevel;

    public function __construct(string $firstName, string $lastName, string $email, string $phoneNumber, string $password, MasteryLevel $masteryLevel)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->masteryLevel = $masteryLevel;
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