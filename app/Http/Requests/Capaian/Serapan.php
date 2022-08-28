<?php

namespace App\Http\Requests\Capaian;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class Serapan extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    // jika bukan dari api, harus ada auth
    if (!request()->is('api/*')) {
      return auth()->user();
    }

    // jika dari api, sudah di validasi via middleware
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
      'thbl' => ['required', 'digits:6'],
      'kolok' => ['required', 'digits:9'],
      'kojab' => ['required', 'digits:6'],
      'spmu' => ['required', 'alpha_num', 'min:4', 'max:4'],
      'eselon' => ['nullable', 'digits:2'],
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
      'thbl.required' => 'Permintaan harus memiliki parameter THBL',
      'thbl.digits' => 'THBL harus :digits karakter',
      'kolok.required' => 'Permintaan harus memiliki parameter KOLOK',
      'kolok.digits' => 'KOLOK harus :digits karakter',
      'kojab.required' => 'Permintaan harus memiliki parameter KOJAB',
      'kojab.digits' => 'KOJAB harus :digits karakter',
      'spmu.required' => 'Permintaan harus memiliki parameter SPMU',
      'spmu.min' => 'SPMU harus :min karakter',
      'spmu.max' => 'SPMU harus :max karakter',
      'eselon.digits' => 'ESELON harus :digits karakter atau null',
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

    // converting errors in one line
    foreach ($errors as $key => $error) {
      $errors[$key] = is_array($error) ? implode(', ', $error) : $error;
    }

    $output = [
      'success' => false,
      'errors' => $errors
    ];

    throw new HttpResponseException(
      response()->json($output, JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
    );
  }
}
