<?php
namespace Omnipay\Acapture\Tests\Exception;

use Omnipay\Acapture\Exception\InvalidPaymentTypeException;
use Omnipay\Tests\TestCase;

class InvalidPaymentTypeExceptionTest extends TestCase
{
    public function testConstruct()
    {
        $exception = new InvalidPaymentTypeException('Oops');
        $this->assertSame('Oops', $exception->getMessage());
    }
}