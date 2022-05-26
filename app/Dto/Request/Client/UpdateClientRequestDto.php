<?php

namespace App\Dto\Request\Client;

use App\Dto\Dto;

final class UpdateClientRequestDto extends Dto
{
    /**
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $username
     * @param string|null $email
     */
    public function __construct(
        private ?string $firstName,
        private ?string  $lastName,
        private ?string  $username,
        private ?string  $email,
    ) {}

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
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
