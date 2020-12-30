<?php


namespace App\Actions;


use Zttp\PendingZttpRequest;
use Zttp\Zttp;


/**
 * Http client action
 * @package App\Actions
 *
 * @method PendingZttpRequest get(string $url, array $queryParams = [])
 * @method PendingZttpRequest post(string $url, array $params = [])
 * @method PendingZttpRequest patch(string $url, array $params = [])
 * @method PendingZttpRequest put(string $url, array $params = [])
 * @method PendingZttpRequest delete(string $url, array $params = [])
 *
 * @method PendingZttpRequest withOptions(array $options)
 * @method PendingZttpRequest withoutRedirecting()
 * @method PendingZttpRequest withoutVerifying()
 * @method PendingZttpRequest asJson()
 * @method PendingZttpRequest asFormParams()
 * @method PendingZttpRequest asMultipart()
 * @method PendingZttpRequest bodyFormat(string $format)
 * @method PendingZttpRequest contentType(string $contentType)
 * @method PendingZttpRequest accept(string $header)
 * @method PendingZttpRequest withHeaders(array $headers)
 * @method PendingZttpRequest withBasicAuth(string $username, string $password)
 * @method PendingZttpRequest withDigestAuth(string $username, string $password)
 * @method PendingZttpRequest withCookies(array $cookies)
 * @method PendingZttpRequest timeout(int $seconds)
 * @method PendingZttpRequest beforeSending(callable $callback)
 */
class Http extends Action
{
	public function __call($name, $arguments)
	{
		return Zttp::{$name}(...$arguments);
	}
}
