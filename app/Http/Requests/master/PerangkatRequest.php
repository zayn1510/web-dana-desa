<?php

namespace App\Http\Requests\master;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PerangkatRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "id_jabatan"=>["required","integer"],
            "nama_lengkap"=>["required","string","max:50"],
            "tempat_lahir"=>["required","string","max:30"],
            "tgl_lahir"=>["required","date"],
            "jenis_kelamin"=>["required","max:1"],
            "no_handphone"=>["required","max:12"],
            "no_sk"=>["required","max:30"],
            "tgl_sk"=>["required","date"],
            "username"=>["required","string","max:30"],
            "password"=>["required","string","max:100"],
            "role"=>["required","string"],
            "email"=>["required","string"]
        ];
    }


    /**
     * Summary of failedValidation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    public function failedValidation(Validator $validator)

    {
        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));

    }
}