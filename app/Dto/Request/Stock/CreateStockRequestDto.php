<?php

namespace App\Dto\Request\Stock;

use App\Dto\Dto;

final class CreateStockRequestDto extends Dto
{

    /**
     * @param string $price
     */
    public function __construct(
        private string $price,
    ) {}

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'price' => $this->price,
        ];
    }
}
