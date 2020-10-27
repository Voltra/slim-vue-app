<?php


namespace App\Actions;


use App\Models\User;
use DI\Container;
use Kelunik\TwoFactor\Oath;

class TwoFactor extends Action
{
	/**
	 * @var Oath
	 */
	protected $otp;

	/**
	 * @var string
	 */
	protected $issuer;

	public function __construct(Container $container)
	{
		parent::__construct($container);
		$this->otp = new Oath();
		$this->issuer = $this->container->get("config")["2fa.issuer"];
	}

	protected function requires2FA(User $user): bool{
		return $user->requires2FA();
	}

	protected function getSeed(User $user): string{
		return $user->twoFactor->discriminant;
	}

	/**
	 * Validate 2FA for the given user
	 * @param User $user
	 * @param string $userCode
	 * @return bool
	 */
	public function validate(User $user, string $userCode): bool{
		if(!$this->requires2FA($user))
			return true;

		$seed = $this->getSeed($user);
		return $this->otp->verifyTotp($seed, $userCode);
	}

	/**
	 * Generate a new discriminant for 2FA
	 * @return string
	 */
	public function newDiscriminant(): string{
		return $this->otp->generateKey();
	}

	/**
	 * Generate the QRCode URI for the given user
	 * @param User $user
	 * @return string
	 */
	public function qrCode(User $user): string{
		if(!$this->requires2FA($user))
			return "";

		$seed = $this->getSeed($user);
		return $this->otp->getUri($seed, $this->issuer, $user->email);
	}

	/**
	 * Get the secret key for the given user
	 * @param User $user
	 * @return string
	 */
	public function secret(User $user): string{
		if(!$this->requires2FA($user))
			return "";

		$seed = $this->getSeed($user);
		return $this->otp->encodeKey($seed);
	}


	/**
	 * Enable 2FA for the given user
	 * @param User $user
	 * @return bool
	 */
	public function enable2FA(User $user): bool{
		if($this->requires2FA($user))
			return true;

		$discr = $this->newDiscriminant();

		return $user->twoFactor()->insert([
			"discriminant" => $discr,
			"latest_code" => null,
		]);
	}
}
