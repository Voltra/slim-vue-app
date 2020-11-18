<?php


namespace App\Mails;


use App\Config\Config;
use Carbon\Carbon;
use DI\DependencyException;
use DI\NotFoundException;
use LazyCollection\Stream;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\BodyRendererInterface;
use Symfony\Component\Mime\Header\Headers;

class Mail extends TemplatedEmail
{
	/**
	 * @var TemplatedEmail
	 */
	protected $email;

	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @var BodyRendererInterface
	 */
	protected $renderer;

	/**
	 * @var MailerInterface
	 */
	protected $mailer;

	/**
	 * Construct a new Mail
	 * @param mixed ...$args
	 * @return static
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public static function create(...$args){
		return new static(...$args);
	}

	/**
	 * Mail constructor.
	 * @param Headers|null $headers
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public function __construct(?Headers $headers = null)
	{
		parent::__construct($headers);
		$this->config = resolve(Config::class)["mail"];
		$this->renderer = resolve(BodyRendererInterface::class);
		$this->mailer = resolve(MailerInterface::class);

		$this->initialSetup();
	}

	/**
	 * Set the template URI relative to the mails' templates directory
	 * @param string $uri
	 * @return Mail
	 */
	public function template(string $uri): self{
		return $this->htmlTemplate("mails/$uri");
	}

	/**
	 * Render and send the email
	 * @param array $context The additional context for the Twig template
	 * @throws TransportExceptionInterface
	 */
	public function send(array $context = []): void{
		$this->render($context);
		$this->mailer->send($this);
	}

	protected function render(array $context = []): void{
		$mailContext = array_merge($this->getContext(), $context, $this->messageContext());
		$this->context($mailContext);
		$this->renderer->render($this);
	}


	protected function initialSetup()
	{
		$from = $this->config["from"];
		$replyTo = $this->config["reply_to"];

		$this->from(new Address($from["addr"], $from["name"] ?? ""))
			->replyTo(new Address($replyTo["addr"], $replyTo["name"] ?? ""))
			->date(Carbon::now());
	}

	/**
	 * @param Address[] $addresses
	 * @return array
	 */
	protected function addrToArr(array $addresses): array{
		return Stream::fromIterable($addresses)
			->map(function(Address $addr){
				return [
					"addr" => $addr->getAddress(),
					"name" => $addr->getName()
				];
			})->toArray();
	}

	protected function messageContext(): array{
		$subject = $this->getSubject();

		return [
			"msg" => [
				"subject" => $subject,
				"title" => $subject,
				"from" => $this->addrToArr($this->getFrom()),
				"to" => $this->addrToArr($this->getTo()),
				"replyTo" => $this->addrToArr($this->getReplyTo()),
				"cc" => $this->addrToArr($this->getCc()),
				"bcc" => $this->addrToArr($this->getBcc()),
				"date" => $this->getDate(),
			],
		];
	}
}
