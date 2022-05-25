<?php

namespace App\Services\Client;

use App\Dto\Request\Client\CreateClientRequestDto;
use App\Dto\Request\Client\UpdateClientRequestDto;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

final class ClientService
{
    public function save(
	    CreateClientRequestDto $dto
    ): Client {
        return Auth::user()->clients()->create($dto->toArray());
    }

    public function update(
        UpdateClientRequestDto $dto,
        Client            $Client
    ): Client {
        $Client->update($dto->toArray());

        return $Client;
    }
}
