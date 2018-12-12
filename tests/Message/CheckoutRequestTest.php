<?php
namespace Omnipay\Acapture\Tests\Message;

use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Omnipay\Acapture\Exception\InvalidPaymentTypeException;
use Omnipay\Acapture\Message\CheckoutRequest;
use Omnipay\Acapture\Message\CheckoutResponse;
use Omnipay\Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    /**
     * @var CheckoutRequest
     */
    protected $request;

    /**
     * @var String
     */
    protected $password;

    /**
     * @var String
     */
    protected $entityId;

    /**
     * @var String
     */
    protected $userId;

    public function setUp()
    {
        $responseInterface = \Phake::mock(Response::class);

        $clientInterface = \Phake::mock(RequestInterface::class);
        \Phake::when($clientInterface)->send()->thenReturn($responseInterface);

        $mockClient = \Phake::mock(Client::class);
        \Phake::when($mockClient)->post(\Phake::anyParameters())->thenReturn($clientInterface);

        $this->request = new CheckoutRequest($mockClient, $this->getHttpRequest());
        $this->request->initialize();

        $this->password = uniqid('', true);
        $this->entityId = uniqid('', true);
        $this->userId = uniqid('', true);
    }

    public function paymentTypes()
    {
        return [
            ["DB"],
            ["PA"]
        ];
    }

    public function testGetTypeEmpty()
    {
        $this->assertSame(null, $this->request->getType());
    }

    /**
     * @param $paymentType
     * @dataProvider paymentTypes
     */
    public function testGetSetTypeUsingValidType($paymentType)
    {
        $this->request->setType($paymentType);
        $this->assertSame($paymentType, $this->request->getType());
    }

    public function testGetSetTypeUsingInvalidType()
    {
        $this->setExpectedException(InvalidPaymentTypeException::class, 'Payment of type BLA not supported');
        $this->request->setType('BLA');
    }

    public function testGetPathReturnsRightPath()
    {
        $this->assertSame('checkouts', $this->request->getPath());
    }

    public function setMockRequestData()
    {
        $this->request
            ->setPassword($this->password)
            ->setUserId($this->userId)
            ->setEntityId($this->entityId)
            ->setType('DB')
            ->setCurrency('EUR')
            ->setAmount('50.02');
    }

    public function testGetData()
    {
        $this->setMockRequestData();

        $expectedData = [
            'authentication.userId' => $this->userId,
            'authentication.password' => $this->password,
            'authentication.entityId' => $this->entityId,
            'amount' => '50.02',
            'currency' => 'EUR',
            'paymentType' => 'DB'
        ];

        $data = $this->request->getData();
        $this->assertSame($expectedData, $data);
    }

    public function testSendWithValidData()
    {
        $this->setMockRequestData();
        $this->assertInstanceOf(CheckoutResponse::class, $this->request->send());
    }

    public function testGetEndpointDefault()
    {
        $this->assertSame('https://test.acaptureservices.com/v1/', $this->request->getEndpoint());
    }

    public function testGetEndpointWithEnv()
    {
        putenv('ACAPTURE_ENDPOINT=https://test.test.test/v5/');

        $this->assertSame('https://test.test.test/v5/', $this->request->getEndpoint());
    }

    public function testGetDataUrl()
    {
        $this->setMockRequestData();
        $this->assertSame(
            'checkouts?'.
            'authentication.userId='.
            $this->userId.
            '&authentication.password='.
            $this->password.
            '&authentication.entityId='.
            $this->entityId.
            '&amount=50.02&currency=EUR&paymentType=DB'
            , $this->request->getDataUrl()
        );
    }
}