<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *      title="Sell Stock request",
 *      description="Buy Stock request body data",
 *      type="object",
 *      required={"boughtStockId", "volume"}
 * )
 */
class SellStockRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="boughtStockId",
     *      description="Id of bought stock which should sell",
     *      example="1"
     * )
     * @var int
     */
    public int $boughtStockId;

    /**
     * @OA\Property(
     *      title="volume",
     *      description="Volume of stocks to buy",
     *      example="15"
     * )
     * @var int
     */
    public int $volume;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->client->entrepreneur->id === Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'boughtStockId' => [
                'required',
                'numeric',
                'exists:clients_stocks,id',
            ],
            'volume' => [
                'required',
                'numeric',
            ],
        ];
    }
}
