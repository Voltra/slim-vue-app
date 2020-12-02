<?php


namespace App\Requests\Auth;


use App\Requests\FormRequest;

class RegisterRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			"username" => "required",
			"password" => "required|min:6",
			"confirmPassword" => "same:password",
			"remember" => "boolean|default:false",
		];
	}

	public function messages(): array
	{
		return [
			"username" => "",
			"password" => "",
			"confirmPassword" => "",
			"remember" => "",
		];
	}

	public function sanitize(array $data)
	{
		return array_merge($data, [
			"remember" => !!($data["remember"] ?? false)
		]);
	}


}
