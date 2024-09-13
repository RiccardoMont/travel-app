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
            'image' => 'image|max:2048|nullable',
            'description' => 'nullable',
            'price' => 'integer|nullable',
            'rating' =>  'integer|nullable',
            'lat' => 'numeric|min:-90|max:90|nullable',
            'lng' => 'numeric|min:-180|max:180|nullable',
            'date_and_hour' => 'required|date_format:Y-m-d\TH:i',
            'public' => 'boolean|nullable',
            'trip_id' => 'exists:trips,id|nullable',
            'status_id' => 'exists:statuses,id|nullable'
        ];
    }
}
