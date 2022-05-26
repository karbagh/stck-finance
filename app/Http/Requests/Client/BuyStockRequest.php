<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *      title="Buy Stock request",
 *      description="Buy Stock request body data",
 *      type="object",
 *      required={"stockId", "volume"}
 * )
 */
class BuyStockRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="stocksId",
     *      description="Id of stock which should buy",
     *      example="1"
     * )
     * @var int
     */
    public int $stockId;

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
            'stockId' => [
                'required',
                'numeric',
                'exists:stocks,id',
            ],
            'volume' => [
                'required',
                'numeric',
            ],
        ];
    }
}
