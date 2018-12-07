<?php
namespace Omnipay\Acapture\Tests;

use Omnipay\Acapture\Gateway;
use Omnipay\Tests\TestCase;

class GatewayTest extends TestCase
{
    /**
     * @var Gateway
     */
    protected $gateway;

    public function setUp()
    {
        $this->gateway = new Gateway();
    }

    public function testGetName()
    {
        $this->assertSame('acapture', $this->gateway->getName());
    }
}