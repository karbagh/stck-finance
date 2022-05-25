<?php

namespace App\Services\Stock;

use App\Models\Corporation;
use App\Dto\Request\Stock\CreateStockRequestDto;
use App\Dto\Request\Stock\UpdateStockRequestDto;
use App\Models\Stock;

final class StockService
{
    /**
     * @param Corporation $corporation
     * @param CreateStockRequestDto $dto
     * @return Stock
     */
    public function save(
        Corporation           $corporation,
        CreateStockRequestDto $dto,
    ): Stock {
        return $corporation->stock()->create($dto->toArray());
    }

    /**
     * @param UpdateStockRequestDto $dto
     * @param Stock $stock
     * @return Stock
     */
    public function update(
        UpdateStockRequestDto $dto,
        Stock           $stock,
    ): Stock {
        $stock->update($dto->toArray());

        return $stock;
    }
}
