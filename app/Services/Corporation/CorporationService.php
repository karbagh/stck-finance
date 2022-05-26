<?php

namespace App\Services\Corporation;

use App\Dto\Request\Corporation\CreateCorporationRequestDto;
use App\Dto\Request\Corporation\UpdateCorporationRequestDto;
use App\Models\Corporation;
use Illuminate\Support\Facades\Auth;

final class CorporationService
{
    public function save(
	    CreateCorporationRequestDto $dto
    ): Corporation {
        return Auth::user()->corporations()->create($dto->toArray());
    }

    public function update(
        UpdateCorporationRequestDto $dto,
        Corporation            $corporation
    ): Corporation {
        $corporation->update($dto->toArray());

        return $corporation;
    }
}
