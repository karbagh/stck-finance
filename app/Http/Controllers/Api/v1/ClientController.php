<?php

namespace App\Http\Controllers\Api\v1;

use App\Dto\Request\Client\UpdateClientRequestDto;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\Client\ClientService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Client\ClientResource;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Dto\Request\Client\CreateClientRequestDto;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
     *     path="/clients/{slug}",
     *     tags={"Clients"},
     *     summary="Showing client.",
     *     description="Showing client with requested slug.",
     *     @OA\Parameter(
     *         description="Slug of neccesery client.",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="adcash", summary="An string value."),
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
     *     path="/clients/{slug}",
     *     tags={"Clients"},
     *     summary="Update client",
     *     description="Update some client for your account.",
     *     @OA\Parameter(
     *         description="Slug of neccesery client.",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="adcash", summary="An string value."),
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
     *     path="/clients/{slug}",
     *     tags={"Clients"},
     *     summary="Delete client",
     *     description="Delete choosed client by slug.",
     *     @OA\Parameter(
     *         description="Slug of neccesery client.",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="adcash", summary="An string value."),
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
}
