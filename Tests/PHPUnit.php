<?php
namespace App\Tests;


use Jasny\PHPUnit\CallbackMockTrait;
use Jasny\PHPUnit\ExpectWarningTrait;
use Jasny\PHPUnit\PrivateAccessTrait;
use Jasny\PHPUnit\SafeMocksTrait;
use PHPUnit\Framework\TestCase;

class PHPUnit extends TestCase{
	use CallbackMockTrait;
	use SafeMocksTrait;
	use ExpectWarningTrait;
	use PrivateAccessTrait;
}
