<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
        	   'id'              => $this->id,
        	   'name'            => $this->name,
	         'status'          => $this->status,
	         'deleted_at'      => $this->deleted_at,
            'categories'      => CategoryResource::make($this->whenLoaded('category'))
        ];
    }
}
