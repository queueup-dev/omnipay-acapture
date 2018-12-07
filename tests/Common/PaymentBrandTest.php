<?php
namespace Omnipay\Acapture\Tests\Common;

use Omnipay\Acapture\Common\PaymentBrand;
use Omnipay\Tests\TestCase;

class PaymentBrandTest extends TestCase
{
    public function testGetPaymentBrands()
    {
        $expectedBrands = [
            'IDEAL'
        ];

        $actualBrands = PaymentBrand::getPaymentBrands();

        $this->assertSame($expectedBrands, $actualBrands);
    }
}