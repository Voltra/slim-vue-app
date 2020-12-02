<?php


namespace App\Requests\Auth;


use App\Requests\FormRequest;

class LoginRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			"username" => "required",
			"password" => "required|min:6",
			"remember" => "boolean|default:false",
			"2fa" => "digits:6",
		];
	}

	public function messages(): array
	{
		return [
			"username" => "",
			"password" => "",
			"remember" => "",
			"2fa" => "",
		];
	}

	public function sanitize(array $data)
	{
		return array_merge($data, [
			"remember" => !!($data["remember"] ?? false)
		]);
	}


}
