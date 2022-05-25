<?php

namespace App\Http\Requests\Corporation;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store Corporation request",
 *      description="Store Corporation request body data",
 *      type="object",
 *      required={"name", "capital"}
 * )
 */
class StoreCorporationRequest extends FormRequest
{
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
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:corporations,name',
            ],
            'capital' => [
                'required',
                'numeric',
                'between:0,99999999.99',
            ],
        ];
    }
}
