<?php
namespace Omnipay\Acapture\Tests\Message;

use Omnipay\Acapture\Message\ServerToServer\PurchaseResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    /**
     * @var PurchaseResponse
     */
    protected $response;

    public function setUp()
    {

        $mockRequest = \Mockery::mock(RequestInterface::class);
        $this->response = new PurchaseResponse($mockRequest, $this->getTestData());
    }

    public function getTestData()
    {
        $json = <<<JSON
{
  "id":"8ac7a4a2678399810167886999b6418b",
  "paymentType":"DB",
  "paymentBrand":"GIROPAY",
  "amount":"92.12",
  "currency":"EUR",
  "descriptor":"4296.0425.2251 Giropay_Channel ",
  "result":{
    "code":"000.200.000",
    "description":"transaction pending"
  },
  "resultDetails":{
    "ExtendedDescription":"Transaction accepted.",
    "ConnectorTxID1":"SHKCEK0DC1",
    "AcquirerResponse":"1000"
  },
  "bankAccount":{
    "iban":"DE14940593100000012346",
    "bic":"TESTDETT421",
    "country":"DE"
  },
  "redirect":{
    "url":"https://test.acaptureservices.com/connectors/demo/simulator.link",
    "parameters":[
      {
        "name":"uuid",
        "value":"8ac7a4a2678399810167886999b6418b"
      },
      {
        "name":"connector",
        "value":"GIROPAY_SEPA"
      },
      {
        "name":"responseURL",
        "value":"http://lb-int:8080/payment/cdkasyncresponse?source=CDK_OT"
      },
      {
        "name":"ndcid",
        "value":"8a829417572279ad015732d66cb427b6_7d765213292e4a148500ae93d7a7757e"
      }
    ]
  },
  "buildNumber":"7469d0e5bd2dccca50bbd107625279e76a2c9ff3@2018-12-04 10:59:49 +0000",
  "timestamp":"2018-12-07 11:24:41+0000",
  "ndc":"8a829417572279ad015732d66cb427b6_7d765213292e4a148500ae93d7a7757e"
}
JSON;
        return json_decode($json, true);
    }

    public function testGetRedirectData()
    {
        $this->assertSame($this->getTestData(), $this->response->getRedirectData());
    }

    public function testGetExternalId()
    {
        $this->assertSame($this->response->getExternalId(), '8ac7a4a2678399810167886999b6418b');
    }

    public function testGetAmount()
    {
        $this->assertSame($this->response->getAmount(), '92.12');

    }

    public function testGetCurrency()
    {
        $this->assertSame($this->response->getCurrency(), 'EUR');
    }

    public function testGetRedirectMethod()
    {
        $this->assertSame($this->response->getRedirectMethod(), 'GET');
    }

    public function testIsSuccessful()
    {
        $this->assertSame($this->response->isSuccessful(), false);
    }

    public function testIsRedirect()
    {
        $this->assertSame(true, $this->response->isRedirect());
    }

    public function testGetRedirectUrl()
    {
        $this->assertSame('https://test.acaptureservices.com/connectors/demo/simulator.link', $this->response->getRedirectUrl());
    }
}