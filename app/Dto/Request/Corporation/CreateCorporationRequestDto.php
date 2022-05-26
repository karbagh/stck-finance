<?php

namespace App\Dto\Request\Corporation;

use App\Dto\Dto;

final class CreateCorporationRequestDto extends Dto
{

    /**
     * @param string $name
     * @param float $capital
     */
    public function __construct(
        private string $name,
        private float  $capital,
    ) {}

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getCapital(): float
    {
        return $this->capital;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'capital' => $this->capital,
        ];
    }
}
