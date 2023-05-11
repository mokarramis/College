<?php

namespace App\Http\Requests;

use App\Models\Term;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class ContentStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'term_id' => 'required|exists:terms,id',
            'title' => 'required|string',
            'video' => 'nullable|file|mimetypes:video/mp4',
            'file' => 'nullable|file',
            'description' => 'nullable',
            'tags' => 'nullable|array',
            'tags.*' => 'required|string|max:255'
        ];
    }

    public function failedValidation (ValidationValidator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'failed',
            'data' => $validator->errors()
        ]));
    }
}
