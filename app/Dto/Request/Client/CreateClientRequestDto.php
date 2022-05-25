<?php

namespace App\Dto\Request\Client;

use App\Dto\Dto;

class CreateClientRequestDto extends Dto
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $username
     * @param string $email
     */
    public function __construct(
        private string $firstName,
        private string  $lastName,
        private string  $username,
        private string  $email,
    ) {}

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'username' => $this->username,
            'email' => $this->email,
        ];
    }
}
