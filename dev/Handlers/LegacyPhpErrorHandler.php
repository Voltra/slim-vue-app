<?php


namespace App\Handlers;

use App\Exceptions\LegacyPhpError;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;

class LegacyPhpErrorHandler
{
	/**
	 * @var Request
	 */
	protected $request;
	/**
	 * @var ExceptionHandler
	 */
	protected $exceptionHandler;
	/**
	 * @var bool
	 */
	protected $displayErrorDetails;
	/**
	 * @var bool
	 */
	protected $logErrors;
	/**
	 * @var bool
	 */
	protected $logErrorDetails;
	/**
	 * @var LoggerInterface
	 */
	protected $logger;

	/**
	 * @param Request $request
	 * @param ExceptionHandler $exceptionHandler
	 * @param bool $displayErrorDetails
	 * @param bool $logErrors
	 * @param bool $logErrorDetails
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	public function __construct(Request $request, ExceptionHandler $exceptionHandler, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails){
		$this->request = $request;
		$this->exceptionHandler = $exceptionHandler;
		$this->displayErrorDetails = $displayErrorDetails;
		$this->logErrors = $logErrors;
		$this->logErrorDetails = $logErrorDetails;
		$this->logger = resolve(LoggerInterface::class);
	}

	public function __invoke(){
		$e = error_get_last();

		if($e){
			$errfile = $e["file"];
			$errline = $e["line"];
			$errstr = $e["message"];
			$errno = $e["type"];

			$msg = "Error #$errno $errstr on line $errline in $errfile";

			switch($errno){
				case E_USER_ERROR:
					$this->logger->error($msg);
					break;

				case E_USER_WARNING:
					$this->logger->warning($msg);
					break;

				case E_USER_NOTICE:
					$this->logger->info($msg);
					break;

				case E_USER_DEPRECATED:
					$this->logger->debug($msg);
					break;

				default:
					// Unknown => critical failure
					$this->logger->critical($msg);
					break;
			}

			throw new LegacyPhpError($errstr, $errno);
		}
	}
}
