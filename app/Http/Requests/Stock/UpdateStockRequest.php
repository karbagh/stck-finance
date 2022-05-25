<?php

namespace App\Http\Requests\Stock;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *      title="Update Stock request",
 *      description="Update Stock request body data",
 *      type="object"
 * )
 */
class UpdateStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->stock->corporation->owner->id === Auth::id();
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
                'numeric',
                'between:0,99999999.99',
            ]
        ];
    }
}
