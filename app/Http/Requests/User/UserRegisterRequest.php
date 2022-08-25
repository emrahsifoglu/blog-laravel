<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Rules\StrongPassword;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
      return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
      return [
        'name' => 'required|string',
        'surname' => 'required|string',
        'email' => 'required|string|email:filter|unique:users,email',
        'phone' => 'required|string',
        'password' => ['required', 'string', 'min:8', new StrongPassword()],
        'passwordRepeat' => 'required|string|same:password'
      ];
    }

    /**
     * @see https://www.codegrepper.com/code-examples/php/return+response+at+failedValidation%28%29+in+request+laravel
     * @see https://laracasts.com/discuss/channels/laravel/how-make-a-custom-formrequest-error-response-in-laravel-55
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
      throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
