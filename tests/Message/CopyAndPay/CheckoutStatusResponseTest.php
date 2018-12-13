<?php
namespace Omnipay\Acapture\Tests\Message;

use Omnipay\Acapture\Message\CopyAndPay\CheckoutStatusResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Tests\TestCase;

class CheckoutStatusResponseTest extends TestCase
{
    /**
     * @var CheckoutStatusResponse
     */
    protected $response;

    public function setUp()
    {

        $mockRequest = \Mockery::mock(RequestInterface::class);
        $this->response = new CheckoutStatusResponse($mockRequest, $this->getTestData());
    }

    public function getTestData()
    {
        $json = <<<JSON
{
    "result": {
        "code": "000.200.000",
        "description": "transaction pending"
    },
    "buildNumber": "1cfb7b1b7b38c37dfd1148419626f7acaa81ef00@2018-12-11 13:28:04 +0000",
    "timestamp": "2018-12-13 09:43:08+0000",
    "ndc": "D3DCB47D63B0D15299C4BD2F6FD562CA.uat01-vm-tx02"
}
JSON;
        return json_decode($json, true);
    }

    public function testGetCheckoutId()
    {
        $this->assertSame('D3DCB47D63B0D15299C4BD2F6FD562CA.uat01-vm-tx02', $this->response->getCheckoutId());
    }

    public function testGetDescription()
    {
        $this->assertSame('transaction pending', $this->response->getDescription());
    }

    public function testGetResultCode()
    {
        $this->assertSame('000.200.000', $this->response->getResultCode());
    }

    public function testIsPending()
    {
        $this->assertSame(true, $this->response->isPending());
    }

    public function testIsSuccessful()
    {
        $this->assertSame(false, $this->response->isSuccessful());
    }
}