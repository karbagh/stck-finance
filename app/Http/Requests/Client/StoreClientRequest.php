<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store Client request",
 *      description="Store Client request body data",
 *      type="object",
 *      required={"firstName", "lastName", "username", "email"}
 * )
 */
class StoreClientRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="firstName",
     *      description="First Name of the new client",
     *      example="John"
     * )
     * @var string
     */
    public string $firstName;

    /**
     * @OA\Property(
     *      title="lastName",
     *      description="Last Name of the new client",
     *      example="Doe"
     * )
     * @var string
     */
    public string $lastName;

    /**
     * @OA\Property(
     *      title="username",
     *      description="Username of the new client",
     *      example="johndoe@gmail.com"
     * )
     * @var string
     */
    public string $username;

    /**
     * @OA\Property(
     *      title="firstName",
     *      description="Name of the new client",
     *      example="John"
     * )
     * @var string
     */
    public string $email;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstName' => [
                'required',
                'string',
                'max:255',
            ],
            'lastName' => [
                'required',
                'string',
                'max:255',
            ],
            'username' => [
                'required',
                'string',
                'email',
                'unique:clients,username',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'unique:clients,email',
                'max:255',
            ],
        ];
    }
}
