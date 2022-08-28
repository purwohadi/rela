<?php

namespace App\Http\Requests\Settings\Struktur;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DaftarPelaksana extends FormRequest
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
      'nrk_to_find' => ['required', 'min:6', 'max:10'],
      'thbl' => ['required'],
      'spmu' => ['required'],
      'kolok' => ['required'],
      'is_bko' => ['required'],
    ];
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'nrk_to_find.required' => 'NRK Atasan diperlukan',
      'nrk_to_find.min' => 'NRK Atasan minimal :min karakter',
      'nrk_to_find.max' => 'NRK Atasan maksimal :max karakter',
      'thbl.required' => 'THBL diperlukan',
      'spmu.required' => 'SPMU Atasan diperlukan',
      'kolok.required' => 'KOLOK Atasan diperlukan',
      'is_bko.required' => 'BKO Atasan diperlukan',
    ];
  }

  /**
   * Handle a failed validation attempt.
   *
   * @param  \Illuminate\Contracts\Validation\Validator  $validator
   * @return void
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
  {
    $errors = (new \Illuminate\Validation\ValidationException($validator))->errors();

    throw new HttpResponseException(
      response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
    );
  }
}
