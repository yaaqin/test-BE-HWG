<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValAddBook extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // return [   
        //     'id' => 'required|num|max:32',
        //     'nama' => 'required|string|max:191',
        //     'kategory_id' => 'required|integer|max:191',
        //     'status' => 'required|string|max:191'
        // ];
    }
}
