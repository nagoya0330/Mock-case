<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
        'image' => 'required|image|mimes:jpeg,png|max:2048',
        'name' => 'required|string|max:255',
        'brand_name' => 'nullable|string|max:255',
        'description' => 'required|string|max:255',
        'condition' => 'required|string',
        'price' => 'required|numeric|min:0',
        'categories' => 'required|array',
        'categories.*' => 'exists:categories,id',
    ];
    }
}
