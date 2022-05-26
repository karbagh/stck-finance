<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'fullName' => $this->full_name,
            'username' => $this->username,
            'budget' => $this->budget,
            'range' => $this->totalRange,
            'email' => $this->email,
            'stocks' => ClientStockResource::collection($this->whenLoaded('stocks')),
        ];
    }
}
