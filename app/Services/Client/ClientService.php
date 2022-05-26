<?php

namespace App\Services\Client;

use Carbon\Carbon;
use Exception;
use App\Models\Stock;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use App\Dto\Request\Client\BuyStockRequestDto;
use App\Dto\Request\Client\SellStockRequestDto;
use App\Dto\Request\Client\CreateClientRequestDto;
use App\Dto\Request\Client\UpdateClientRequestDto;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

final class ClientService
{
    /**
     * @param CreateClientRequestDto $dto
     * @return Client
     */
    public function save(
	    CreateClientRequestDto $dto
    ): Client {
        return Auth::user()->clients()->create($dto->toArray());
    }

    /**
     * @param UpdateClientRequestDto $dto
     * @param Client $Client
     * @return Client
     */
    public function update(
        UpdateClientRequestDto $dto,
        Client            $Client
    ): Client {
        $Client->update($dto->toArray());

        return $Client;
    }

    /**
     * @param BuyStockRequestDto $dto
     * @param Client $client
     * @return Client
     * @throws Exception
     */
    public function buy(
        BuyStockRequestDto $dto,
        Client $client,
    ): Client {
        $stock = Stock::find($dto->getStockId());

        try {
            DB::transaction(function () use ($client, $dto, $stock) {
                $client->decrement('budget', $stock->price * $dto->getVolume());

                if ($client->budget < 0) {
                    throw new ConflictHttpException(trans('messages.fail.stock.budget.less'));
                }

                $client->stocks()->attach($stock->id, [
                    'volume' => $dto->getVolume(),
                    'bought_price' => $stock->price,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            });

        } catch (ConflictHttpException $e) {
            throw new $e($e->getMessage());
        } catch (Exception $e) {
            throw new Exception(trans('messages.fail.stock.buy'));
        }

        return $client->load('stocks');
    }

    /**
     * @param SellStockRequestDto $dto
     * @param Client $client
     * @return Client
     * @throws Exception
     */
    public function sell(
        SellStockRequestDto $dto,
        Client $client,
    ): Client {
        $boughtStock = $client->stocks()->wherePivot('id', $dto->getBoughtStockId())->first();

        try {
            DB::transaction(function () use ($boughtStock, $client, $dto) {
                if ($boughtStock->pivot->volume - $dto->getVolume() < 0) {
                    throw new ConflictHttpException(trans('messages.fail.stock.volume.less'));
                }

                $boughtStock->pivot->where('id', $dto->getBoughtStockId())->decrement('volume', $dto->getVolume());
                $client->increment('budget', $dto->getVolume() * $boughtStock->price);
            });
        } catch (ConflictHttpException $e) {
            throw new $e($e->getMessage());
        } catch (Exception $e) {
            throw new Exception(trans('messages.fail.stock.buy'));
        }

        return $client->load('stocks');
    }
}
