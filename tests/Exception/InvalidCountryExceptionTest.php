<?php
namespace Omnipay\Acapture\Tests\Exception;

use Omnipay\Acapture\Exception\InvalidCountryException;
use Omnipay\Tests\TestCase;

class InvalidCountryExceptionTest extends TestCase
{
    public function testConstructor()
    {
        $exception = new InvalidCountryException('Oops');
        $this->assertSame('Oops', $exception->getMessage());
    }
}