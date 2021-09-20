<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request;
use JsonSerializable;

class OptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
        	   'id'           => $this->id,
	         'name'         => $this->name,
	         'status'       => $this->status,
	         'deleted_at'   => $this->deleted_at
        ];
    }
}
