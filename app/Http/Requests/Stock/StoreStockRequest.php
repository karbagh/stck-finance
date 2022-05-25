<?php

namespace App\Http\Requests\Stock;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *      title="Store Stock request",
 *      description="Store Stock request body data",
 *      type="object",
 *      required={"price"}
 * )
 */
class StoreStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->corporation->owner->id === Auth::id();
    }

    /**
     * @OA\Property(
     *      title="price",
     *      description="Price of the new corporation",
     *      example="99999999.99"
     * )
     *
     * @var float
     */
    public float $price;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'price' => [
                'required',
                'numeric',
                'between:0,99999999.99',
            ]
        ];
    }
}
