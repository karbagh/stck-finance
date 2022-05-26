<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Client;
use App\Models\Stock;
use App\Models\Corporation;
use Illuminate\Http\JsonResponse;
use App\Services\Stock\StockService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Stock\StockResource;
use App\Http\Requests\Stock\StoreStockRequest;
use App\Http\Requests\Stock\UpdateStockRequest;
use App\Dto\Request\Stock\CreateStockRequestDto;
use App\Dto\Request\Stock\UpdateStockRequestDto;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(
 *     name="Stocks",
 *     description="API Endpoints of Stocks"
 * )
 */
final class StockController extends ApiController
{
    /**
     * @OA\Get (
     *     path="/stocks",
     *     tags={"Stocks"},
     *     summary="List of stocks",
     *     description="Get the list of stocks which owner is current user.",
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
        return StockResource::collection(
            Auth::user()->stocks
        );
    }

    /**
     * @OA\Post  (
     *     path="/stocks/{corporation:slug}",
     *     tags={"Stocks"},
     *     summary="Store stock",
     *     description="Create some stock for your account.",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreStockRequest")
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
     * Store a corporation in storage.
     *
     * @param StoreStockRequest $request
     * @return StockResource
     */
    public function store(
        Corporation $corporation,
        StoreStockRequest $request,
        StockService $service
    ): StockResource {
        return StockResource::make($service->save($corporation, new CreateStockRequestDto(
            $request->get('price'),
        )));
    }

    /**
     * @OA\Get (
     *     path="/stocks/{id}",
     *     tags={"Stocks"},
     *     summary="Showing stock.",
     *     description="Showing stock with requested slug.",
     *     @OA\Parameter(
     *         description="Slug of neccesery corporation.",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An int value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *      )
     * )
     *
     * Return resource of corporation.
     *
     * @param Stock $stock
     * @return StockResource
     */
    public function show(
        Stock $stock
    ): StockResource {
        return StockResource::make($stock);
    }

    /**
     * @OA\Put (
     *     path="/stocks/{slug}",
     *     tags={"Stocks"},
     *     summary="Update corporation",
     *     description="Update some corporation for your account.",
     *     @OA\Parameter(
     *         description="Slug of neccesery corporation.",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="adcash", summary="An string value."),
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateStockRequest")
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
     * @param UpdateStockRequest $request
     * @param Stock $stock
     * @param StockService $service
     * @return StockResource
     */
    public function update(
        UpdateStockRequest $request,
        Stock $stock,
        StockService $service,
    ): StockResource {
        return StockResource::make($service->update(new UpdateStockRequestDto(
            $request->get('price') ?? $stock->price,
        ), $stock));
    }

    /**
     * @OA\Delete (
     *     path="/stocks/{slug}",
     *     tags={"Stocks"},
     *     summary="Delete corporation",
     *     description="Delete choosed corporation by slug.",
     *     @OA\Parameter(
     *         description="Slug of neccesery corporation.",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="adcash", summary="An string value."),
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
     * @param Stock $stock
     * @return array
     */
    public function destroy(Stock $stock): array
    {
        $stock->delete();

        return JsonResponse::message(trans('messages.success.destroyed', [
            'item' => 'Stock'
        ]));
    }
}
