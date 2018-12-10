<?php
namespace Omnipay\Acapture\Tests\Message;

use Mockery\MockInterface;
use Omnipay\Acapture\Message\PaymentStatusResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Tests\TestCase;

class PaymentStatusResponseTest extends TestCase
{
    /**
     * @var MockInterface
     */
    protected $mockRequest;

    public function setUp()
    {
        $this->mockRequest = \Mockery::mock(RequestInterface::class);
    }

    /**
     * Returns the test data.
     *
     * @return string
     */
    public function getPendingTestData()
    {
        $json = <<<JSON
{
  "result":{
    "code":"000.200.000",
    "description":"transaction pending"
  },
  "buildNumber":"7469d0e5bd2dccca50bbd107625279e76a2c9ff3@2018-12-04 10:59:49 +0000",
  "timestamp":"2018-12-10 10:36:11+0000",
  "ndc":"97A8D6FC198C7528D451077D1A8200CE.uat01-vm-tx01"
}
JSON;
        return json_decode($json, true);
    }

    /**
     * Returns the test data.
     *
     * @return string
     */
    public function getSuccessData()
    {
        $json = <<<JSON
{
  "result":{
    "code":"000.000.000",
    "description":"transaction success"
  },
  "buildNumber":"7469d0e5bd2dccca50bbd107625279e76a2c9ff3@2018-12-04 10:59:49 +0000",
  "timestamp":"2018-12-10 10:36:11+0000",
  "ndc":"97A8D6FC198C7528D451077D1A8200CE.uat01-vm-tx01"
}
JSON;

        return json_decode($json, true);
    }

    public function testIsSuccessfulWithPendingData()
    {
        $this->response = new PaymentStatusResponse($this->mockRequest, $this->getPendingTestData());
        $this->assertSame(false, $this->response->isSuccessful());
    }

    public function testIsSuccessfulWithSuccessData()
    {
        $this->response = new PaymentStatusResponse($this->mockRequest, $this->getSuccessData());
        $this->assertSame(true, $this->response->isSuccessful());
    }

    public function testIsPendingfulWithPendingData()
    {
        $this->response = new PaymentStatusResponse($this->mockRequest, $this->getPendingTestData());
        $this->assertSame(true, $this->response->isPending());
    }

    public function testIsPendingWithSuccessData()
    {
        $this->response = new PaymentStatusResponse($this->mockRequest, $this->getSuccessData());
        $this->assertSame(false, $this->response->isPending());
    }

    public function testGetResultCode()
    {
        $this->response = new PaymentStatusResponse($this->mockRequest, $this->getSuccessData());
        $this->assertSame('000.000.000', $this->response->getResultCode());
    }

    public function testGetDescription()
    {
        $this->response = new PaymentStatusResponse($this->mockRequest, $this->getSuccessData());
        $this->assertSame('transaction success', $this->response->getDescription());
    }

    public function testGetTransactionId()
    {
        $this->response = new PaymentStatusResponse($this->mockRequest, $this->getSuccessData());
        $this->assertSame('97A8D6FC198C7528D451077D1A8200CE.uat01-vm-tx01', $this->response->getTransactionId());
    }
}