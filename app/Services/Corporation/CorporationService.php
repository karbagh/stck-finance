<?php

namespace App\Services\Corporation;

use App\Dto\Request\Corporation\CreateClientRequestDto;
use App\Dto\Request\Corporation\UpdateClientRequestDto;
use App\Models\Corporation;
use Illuminate\Support\Facades\Auth;

final class CorporationService
{
    public function save(
	    CreateClientRequestDto $dto
    ): Corporation {
        return Auth::user()->corporations()->create($dto->toArray());
    }

    public function update(
        UpdateClientRequestDto $dto,
        Corporation            $corporation
    ): Corporation {
        $corporation->update($dto->toArray());

        return $corporation;
    }
}
