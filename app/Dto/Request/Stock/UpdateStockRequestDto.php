<?php

namespace App\Dto\Request\Stock;

use App\Dto\Dto;

final class UpdateStockRequestDto extends Dto
{

    /**
     * @param float $price
     */
    public function __construct(
        private float $price,
    ) {}

    /**
     * @return float
     */
    public function getPrice(): float
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
