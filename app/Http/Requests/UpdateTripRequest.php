<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTripRequest extends FormRequest
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
            'title' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'start' => 'nullable',
            'end' => 'nullable',
            'description' => 'nullable',
            'price' => 'nullable',
            'public' => 'nullable',
            'status_id' => 'exists:statuses,id'
        ];
    }
}
