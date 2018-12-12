<?php
namespace Omnipay\Acapture\Tests\Message;

use Omnipay\Acapture\Message\CheckoutResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Tests\TestCase;

class CheckoutResponseTest extends TestCase
{
    /**
     * @var CheckoutResponse
     */
    protected $response;

    public function setUp()
    {
        $mockRequest = \Mockery::mock(RequestInterface::class);
        $this->response = new CheckoutResponse($mockRequest, $this->getTestData());
    }

    public function getTestData()
    {
        $json = <<<JSON
{
  "result":{
    "code":"000.200.100",
    "description":"successfully created checkout"
  },
  "buildNumber":"1cfb7b1b7b38c37dfd1148419626f7acaa81ef00@2018-12-11 13:28:04 +0000",
  "timestamp":"2018-12-12 15:23:34+0000",
  "ndc":"C097D2AB8D282AC99874CB3510D4A65A.uat01-vm-tx03",
  "id":"C097D2AB8D282AC99874CB3510D4A65A.uat01-vm-tx03"
}
JSON;
        return json_decode($json, true);
    }

    public function testGetCheckoutId()
    {
        $this->assertSame('C097D2AB8D282AC99874CB3510D4A65A.uat01-vm-tx03', $this->response->getCheckoutId());
    }

    public function testGetEmbedPath()
    {
        $this->assertSame('https://test.acaptureservices.com/v1/paymentWidgets.js', $this->response->getEmbedPath());
    }

    public function testGetEmbedPathWithEnv()
    {
        putenv('ACAPTURE_EMBED_PATH=https://test.test.test/embed123.js');
        $this->assertSame('https://test.test.test/embed123.js', $this->response->getEmbedPath());
    }

    public function testIsSuccessful()
    {
        $this->assertSame($this->response->isSuccessful(), false);
    }

    public function testIsRedirect()
    {
        $this->assertSame(false, $this->response->isRedirect());
    }

    public function testGetEmbedUrl()
    {
        putenv('ACAPTURE_EMBED_PATH=https://test.test.test/embed123.js');
        $this->assertSame('https://test.test.test/embed123.js?checkoutId='
            . $this->response->getCheckoutId()
            , $this->response->getEmbedUrl()
        );
    }
}