<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\Client\ClientService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Client\ClientResource;
use App\Http\Requests\Client\BuyStockRequest;
use App\Http\Requests\Client\SellStockRequest;
use App\Dto\Request\Client\BuyStockRequestDto;
use App\Dto\Request\Client\SellStockRequestDto;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Dto\Request\Client\CreateClientRequestDto;
use App\Dto\Request\Client\UpdateClientRequestDto;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(
 *     name="Clients",
 *     description="API Endpoints of Clients"
 * )
 */
final class ClientController extends ApiController
{
    /**
     * @OA\Get (
     *     path="/clients",
     *     tags={"Clients"},
     *     summary="List of clients",
     *     description="Get the list of clients which owner is current user.",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
        return ClientResource::collection(
            Auth::user()->clients
        );
    }

    /**
     * @OA\Post  (
     *     path="/clients",
     *     tags={"Clients"},
     *     summary="Store client",
     *     description="Create some client for your account.",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreClientRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *
     * Store a client in storage.
     *
     * @param StoreClientRequest $request
     * @return ClientResource
     */
    public function store(
        StoreClientRequest $request,
        ClientService $service
    ): ClientResource {
        return ClientResource::make($service->save(new CreateClientRequestDto(
            $request->get('firstName'),
            $request->get('lastName'),
            $request->get('username'),
            $request->get('email'),
        )));
    }

    /**
     * @OA\Get (
     *     path="/clients/{id}",
     *     tags={"Clients"},
     *     summary="Showing client.",
     *     description="Showing client with requested id.",
     *     @OA\Parameter(
     *         description="Id of neccesery client.",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An string value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *      )
     * )
     *
     * Return resource of client.
     *
     * @param Client $client
     * @return ClientResource
     */
    public function show(
        Client $client
    ): ClientResource {
        return ClientResource::make($client);
    }

    /**
     * @OA\Put (
     *     path="/clients/{id}",
     *     tags={"Clients"},
     *     summary="Update client",
     *     description="Update some client for your account.",
     *     @OA\Parameter(
     *         description="Id of neccesery client.",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An string value."),
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateClientRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *
     * @param UpdateClientRequest $request
     * @param Client $client
     * @param ClientService $service
     * @return ClientResource
     */
    public function update(
        UpdateClientRequest $request,
        Client $client,
        ClientService $service,
    ): ClientResource {
        return ClientResource::make($service->update(new UpdateClientRequestDto(
            $request->get('firstName') ?? $client->first_name,
            $request->get('lastName') ?? $client->last_name,
            $request->get('username') ?? $client->username,
            $request->get('email') ?? $client->email,
        ), $client));
    }

    /**
     * @OA\Delete (
     *     path="/clients/{id}",
     *     tags={"Clients"},
     *     summary="Delete client",
     *     description="Delete choosed client by id.",
     *     @OA\Parameter(
     *         description="Id of neccesery stock.",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An string value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return array
     */
    public function destroy(Client $client): array
    {
        $client->delete();

        return JsonResponse::message(trans('messages.success.destroyed', [
            'item' => 'Client'
        ]));
    }

    /**
     * @OA\Get (
     *     path="/clients/{id}/stocks",
     *     tags={"Clients"},
     *     summary="Get list of stock for client",
     *     description="With this end point you can get list of stock buyed/selled.",
     *     @OA\Parameter(
     *         description="Id of neccesery client.",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An string value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *
     * Save stock relation for client to storage.
     *
     * @param Client $client
     * @param BuyStockRequest $request
     * @return ClientResource
     */
    public function stocks(
        Client $client,
    ): ClientResource {
        return ClientResource::make($client->load('stocks'));
    }

    /**
     * @OA\Post  (
     *     path="/clients/{id}/stocks/buy",
     *     tags={"Clients"},
     *     summary="Buy stock for client",
     *     description="With this end point you can buy stock for client.",
     *     @OA\Parameter(
     *         description="Id of neccesery client.",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An string value."),
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/BuyStockRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *
     * Save stock relation for client to storage.
     *
     * @param Client $client
     * @param BuyStockRequest $request
     * @return ClientResource
     */
    public function buy(
        Client $client,
        BuyStockRequest $request,
        ClientService $service,
    ): ClientResource {
        return ClientResource::make($service->buy(new BuyStockRequestDto(
            $request->get('stockId'),
            $request->get('volume'),
        ), $client));
    }

    /**
     * @OA\Post  (
     *     path="/clients/{id}/stocks/sell",
     *     tags={"Clients"},
     *     summary="Sell stock for client",
     *     description="With this end point you can sell stock for client.",
     *     @OA\Parameter(
     *         description="Id of neccesery client.",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An string value."),
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SellStockRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *
     * Save stock relation for client to storage.
     *
     * @param Client $client
     * @param SellStockRequest $request
     * @param ClientService $service
     * @return ClientResource
     * @throws Exception
     */
    public function sell(
        Client $client,
        SellStockRequest $request,
        ClientService $service,
    ): ClientResource {
        return ClientResource::make($service->sell(new SellStockRequestDto(
            $request->get('boughtStockId'),
            $request->get('volume'),
        ), $client));
    }
}
