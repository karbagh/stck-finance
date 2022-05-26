<?php

namespace App\Dto\Request\Client;

use App\Dto\Dto;

final class SellStockRequestDto extends Dto
{
    /**
     * @param int $boughtStockId
     * @param int $volume
     */
    public function __construct(
       private int $boughtStockId,
       private int $volume,
    ) {}

    /**
     * @return int
     */
    public function getBoughtStockId(): int
    {
        return $this->boughtStockId;
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
            'boughtStockId' => $this->boughtStockId,
            'volume' => $this->volume,
        ];
    }
}
