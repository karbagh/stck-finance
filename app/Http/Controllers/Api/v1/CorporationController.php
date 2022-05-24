<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreCorporationRequest;
use App\Http\Requests\UpdateCorporationRequest;
use App\Models\Corporation;

final class CorporationController extends ApiController
{
    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     summary="Updates a user",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An int value."),
     *         @OA\Examples(example="uuid", value="0006faf6-7a61-426c-9034-579f2cfcfa83", summary="An UUID value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCorporationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCorporationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Corporation  $corporation
     * @return \Illuminate\Http\Response
     */
    public function show(Corporation $corporation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Corporation  $corporation
     * @return \Illuminate\Http\Response
     */
    public function edit(Corporation $corporation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCorporationRequest  $request
     * @param  \App\Models\Corporation  $corporation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCorporationRequest $request, Corporation $corporation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Corporation  $corporation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Corporation $corporation)
    {
        //
    }
}
