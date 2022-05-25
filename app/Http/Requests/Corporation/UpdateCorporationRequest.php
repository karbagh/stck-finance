<?php

namespace App\Http\Requests\Corporation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *      title="Update Corporation request",
 *      description="Update Corporation request body data",
 *      type="object"
 * )
 */
class UpdateCorporationRequest extends FormRequest
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
     *      title="name",
     *      description="Name of the new corporation",
     *      example="Adcash"
     * )
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *      title="capital",
     *      description="Capital of the new corporation",
     *      example="99999999.99"
     * )
     *
     * @var float
     */
    public float $capital;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:255',
            ],
            'capital' => [
                'numeric',
                'between:0,99999999.99',
            ],
        ];
    }
}
