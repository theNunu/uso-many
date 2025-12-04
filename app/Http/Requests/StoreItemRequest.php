<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreItemRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'catalog_ids' => 'required|array',
            'catalog_ids.*' => 'exists:catalogs,catalog_id',

            'vigente_desde' => 'required|date',
            'vigente_hasta' => 'required|date|after:vigente_desde',
            /*
                'start_at'    => 'required|date|date_format:Y-m-d',
                'end_at'      => 'required|date|date_format:Y-m-d|after_or_equal:start_at',
             */
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Errores de validación',
            'errors' => $validator->errors(),
        ], 422));
    }
}
