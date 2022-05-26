<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Corporation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;
use App\Services\Corporation\CorporationService;
use App\Http\Resources\Corporation\CorporationResource;
use App\Http\Requests\Corporation\StoreCorporationRequest;
use App\Http\Requests\Corporation\UpdateCorporationRequest;
use App\Dto\Request\Corporation\CreateCorporationRequestDto;
use App\Dto\Request\Corporation\UpdateCorporationRequestDto;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(
 *     name="Corporations",
 *     description="API Endpoints of Corporations"
 * )
 */
final class CorporationController extends ApiController
{
    /**
     * @OA\Get (
     *     path="/corporations",
     *     tags={"Corporations"},
     *     summary="List of corporations",
     *     description="Get the list of corporations which owner is current user.",
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
        return CorporationResource::collection(
            Auth::user()->corporations
        );
    }

    /**
     * @OA\Post  (
     *     path="/corporations",
     *     tags={"Corporations"},
     *     summary="Store corporation",
     *     description="Create some corporation for your account.",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreCorporationRequest")
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
     * @param StoreCorporationRequest $request
     * @return CorporationResource
     */
    public function store(
        StoreCorporationRequest $request,
        CorporationService $service
    ): CorporationResource {
        return CorporationResource::make($service->save(new CreateCorporationRequestDto(
            $request->get('name'),
            $request->get('capital'),
        )));
    }

    /**
     * @OA\Get (
     *     path="/corporations/{slug}",
     *     tags={"Corporations"},
     *     summary="Showing corporation.",
     *     description="Showing corporation with requested slug.",
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
     *      )
     * )
     *
     * Return resource of corporation.
     *
     * @param Corporation $corporation
     * @return CorporationResource
     */
    public function show(
        Corporation $corporation
    ): CorporationResource {
        return CorporationResource::make($corporation);
    }

    /**
     * @OA\Put (
     *     path="/corporations/{slug}",
     *     tags={"Corporations"},
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
     *          @OA\JsonContent(ref="#/components/schemas/UpdateCorporationRequest")
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
     * @param UpdateCorporationRequest $request
     * @param Corporation $corporation
     * @param CorporationService $service
     * @return CorporationResource
     */
    public function update(
        UpdateCorporationRequest $request,
        Corporation              $corporation,
        CorporationService            $service,
    ): CorporationResource {
        return CorporationResource::make($service->update(new UpdateCorporationRequestDto(
            $request->get('name') ?? $corporation->name,
            $request->get('capital') ?? $corporation->capital,
        ), $corporation));
    }

    /**
     * @OA\Delete (
     *     path="/corporations/{slug}",
     *     tags={"Corporations"},
     *     summary="Delete corporation",
     *     description="Delete choosed corporation by slug.",
     *     @OA\Parameter(
     *         description="Slug of neccesery corporation.",
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
     * @param Corporation $corporation
     * @return array
     */
    public function destroy(Corporation $corporation): array
    {
        $corporation->delete();

        return JsonResponse::message(trans('messages.success.destroyed', [
            'item' => 'Corporation'
        ]));
    }
}
