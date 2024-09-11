<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable',
            'price' => 'nullable|integer',
            'rating' =>  'nullable|integer',
            'lat' => 'nullable|numeric|min:-90|max:90',
            'lng' => 'nullable|numeric|min:-180|max:180',
            'datetime' => 'required|date_format:Y-m-d\TH:i',
            'checked' => 'nullable',
            'public' => 'nullable',
        ];
    }
}
