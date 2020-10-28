<?php


namespace App\Actions;


use App\Models\User;
use DI\Container;
use RobThree\Auth\Providers\Qr\IQRCodeProvider;
use RobThree\Auth\TwoFactorAuth;

class TwoFactor extends Action
{
	/**
	 * @var TwoFactorAuth
	 */
	protected $otp;

	/**
	 * @var string
	 */
	protected $issuer;

	/**
	 * @var string
	 */
	protected $algo;

	/**
	 * @var int
	 */
	protected $digits;

	/**
	 * @var mixed
	 */
	protected $period;

	/**
	 * @var IQRCodeProvider
	 */
	protected $qrProvider;
	/**
	 * @var string
	 */
	protected $labelField;

	/**
	 * @inheritDoc
	 * @throws \RobThree\Auth\TwoFactorAuthException
	 */
	public function __construct(Container $container)
	{
		parent::__construct($container);
		$this->issuer = $this->config["2fa.issuer"];
		$this->algo = $this->config["2fa.algo"];
		$this->digits = $this->config["2fa.digits"];
		$this->period = $this->config["2fa.period"];
		$this->labelField = $this->config["2fa.label_field"];

		$class = $this->config["2fa.qr_provider"];
		$this->qrProvider = new $class();

		$this->otp = new TwoFactorAuth(
			$this->issuer,
			$this->digits,
			$this->period,
			$this->algo,
			$this->qrProvider
		);
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
		return $this->otp->verifyCode($seed, $userCode);
	}

	/**
	 * Generate a new discriminant for 2FA
	 * @return string
	 * @throws \RobThree\Auth\TwoFactorAuthException
	 */
	public function newDiscriminant(): string{
		return $this->otp->createSecret();
	}

	/**
	 * Generate the QRCode URI for the given user
	 * @param User $user
	 * @return string
	 * @throws \RobThree\Auth\TwoFactorAuthException
	 */
	public function qrCode(User $user): string{
		if(!$this->requires2FA($user))
			return "";

		$seed = $this->getSeed($user);
		return $this->otp->getQRCodeImageAsDataUri($user->{$this->labelField}, $seed);
	}

	/**
	 * Get the secret key for the given user
	 * @param User $user
	 * @return string
	 */
	public function secret(User $user): string{
		if(!$this->requires2FA($user))
			return "";

		return $this->getSeed($user);
	}


	/**
	 * Enable 2FA for the given user
	 * @param User $user
	 * @throws \RobThree\Auth\TwoFactorAuthException
	 */
	public function enable2FA(User $user){
		if($this->requires2FA($user))
			return;

		$discr = $this->newDiscriminant();
//		dd($discr);

		$tfa = new \App\Models\TwoFactor();
		$tfa->discriminant = $discr;
		$tfa->latest_code = null;

		$user->twoFactor()->save($tfa);
	}

	/**
	 * Disable 2FA for the given user
	 * @param User $user
	 */
	public function disable2FA(User $user){
		if(!$this->requires2FA($user))
			return;

		$user->twoFactor()->delete();
	}
}
