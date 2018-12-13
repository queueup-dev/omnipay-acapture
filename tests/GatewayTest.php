<?php
namespace Omnipay\Acapture\Tests;

use Omnipay\Acapture\Gateway;
use Omnipay\Acapture\Message\CopyAndPay\CheckoutRequest;
use Omnipay\Acapture\Message\CopyAndPay\CheckoutStatusRequest;
use Omnipay\Acapture\Message\ServerToServer\PaymentStatusRequest;
use Omnipay\Acapture\Message\ServerToServer\PurchaseRequest;
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

    public function testPurchase()
    {
        $purchase = $this->gateway->purchase();

        $this->assertInstanceOf(PurchaseRequest::class, $purchase);
    }

    public function testEmbed()
    {
        $purchase = $this->gateway->embed();

        $this->assertInstanceOf(CheckoutRequest::class, $purchase);
    }

    public function testPaymentStatus()
    {
        $paymentStatus = $this->gateway->paymentStatus('12345');

        $this->assertInstanceOf(PaymentStatusRequest::class, $paymentStatus);
        $this->assertSame('12345', $paymentStatus->getPaymentId());
    }

    public function testCheckoutStatus()
    {
        $checkoutStatus = $this->gateway->checkoutStatus('12345');

        $this->assertInstanceOf(CheckoutStatusRequest::class, $checkoutStatus);
        $this->assertSame('12345', $checkoutStatus->getCheckoutId());
    }

    public function testGetSetPassword()
    {
        $this->gateway->setPassword('12345');
        $this->assertSame($this->gateway->getPassword(), '12345');
    }

    public function testGetSetUserId()
    {
        $this->gateway->setUserId('user21');
        $this->assertSame($this->gateway->getUserId(), 'user21');
    }

    public function testGetSetEntityId()
    {
        $this->gateway->setEntityId('entity123');
        $this->assertSame($this->gateway->getEntityId(), 'entity123');
    }

    public function  testDateIsTransmitted()
    {
        $this->gateway->setPassword('12345');
        $this->gateway->setUserId('user21');
        $this->gateway->setEntityId('entity123');

        // It's not really an unit-test but quite important to test anyway.
        $purchase = $this->gateway->purchase();

        $this->assertSame('12345', $purchase->getPassword());
        $this->assertSame('user21', $purchase->getUserId());
        $this->assertSame('entity123', $purchase->getEntityId());
    }
}