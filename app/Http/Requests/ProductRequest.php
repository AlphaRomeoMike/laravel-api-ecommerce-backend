<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|string',
            'price'         => 'required',
            'weight'        => 'required',
            'unit'          => 'required',
            'description'   => 'required|string',
            'stock'         => 'required|integer',
            'images'        => 'required|array',
            'categories'    => 'required|array',
            'subcategories' => 'required|array',
            'status'        => 'required|boolean'
        ];
    }
}
