<?php

namespace App\Dto\Request\Client;

use App\Dto\Dto;

final class BuyStockRequestDto extends Dto
{
    /**
     * @param int $stockId
     * @param int $volume
     */
    public function __construct(
       private int $stockId,
       private int $volume,
    ) {}

    /**
     * @return int
     */
    public function getStockId(): int
    {
        return $this->stockId;
    }

    /**
     * @return int
     */
    public function getVolume(): int
    {
        return $this->volume;
    }

    public function toArray(): array
    {
        return [
            'stockId' => $this->stockId,
            'volume' => $this->volume,
        ];
    }
}
