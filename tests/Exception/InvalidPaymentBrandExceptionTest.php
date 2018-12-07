<?php
namespace Omnipay\Acapture\Tests\Exception;

use Omnipay\Acapture\Exception\InvalidPaymentBrandException;
use Omnipay\Tests\TestCase;

class InvalidPaymentBrandExceptionTest extends TestCase
{
    public function testConstructor()
    {
        $exception = new InvalidPaymentBrandException('Oops');
        $this->assertSame('Oops', $exception->getMessage());
    }
}