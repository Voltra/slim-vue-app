<?php


namespace App\Request;


use App\Actions\Validator;
use App\Exceptions\InvalidFormRequest;
use Psr\Http\Message\ServerRequestInterface;
use Rakit\Validation\Validation;

abstract class FormRequest
{
	/**
	 * @var ServerRequestInterface
	 */
	protected $request;

	/**
	 * @var Validation|null
	 */
	protected $validation;

	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * FormRequest constructor.
	 * @param ServerRequestInterface $request
	 * @throws InvalidFormRequest
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	public function __construct(ServerRequestInterface $request)
	{
		$this->request = $request;
		$this->validator = resolve(Validator::class);
		$this->process();
	}

	public function getValidation(): ?Validation{
		return $this->validation;
	}

	/**
	 * @return ServerRequestInterface
	 */
	public function getRequest(): ServerRequestInterface
	{
		return $this->request;
	}

	/**
	 * Get the validated data
	 * @return array
	 */
	public function validatedData(): array{
		$v = $this->getValidation();
		return $v === null ? [] : $v->getValidData();
	}

	public function sanitize(array $data){
		return $data;
	}

	public function data(): array{
		return $this->validator->dataFrom($this->getRequest());
	}

	public function rules(): array{
		return [];
	}

	public function messages(): array{
		return [];
	}

	/**
	 * @throws InvalidFormRequest
	 */
	protected function process(): void
	{
		try{
			$data = $this->sanitize($this->data());

			$this->validation = $this->validator->makeValidation(
				$data,
				$this->messages(),
				$this->rules()
			);

			$this->validation->validate();
		}catch (\Throwable $e){
			dd($e);
			$errors = [];
			if($this->validation !== null)
				$errors = $this->validation->errors()->toArray();

			throw new InvalidFormRequest($errors);
		}
	}
}
