<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientStockResource extends JsonResource
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
            'corporation' => $this->corporation->name,
            'price' => $this->price,
            'boughtStockId' => $this->pivot->id,
            'volume' => $this->pivot->volume,
            'boughtPrice' => (float) $this->pivot->bought_price,
            'range' => $this->pivot->volume * $this->price - $this->pivot->volume * (float) $this->pivot->bought_price,
            'updatedAt' => $this->updated_at->toDateTimeString(),
        ];
    }
}
