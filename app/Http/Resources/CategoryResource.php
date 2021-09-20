<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
        	   'id'        => $this->id,
            'name'      => $this->name,
	         'status'    => $this->status,
	         'deleted_at'=> $this->deleted_at,
	         'subcategories'   => SubCategoryResource::collection($this->whenLoaded('subcategories'))
        ];
    }
}
