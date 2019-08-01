<?php
namespace Omnipay\Acapture\Tests\Message;

use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Omnipay\Acapture\Exception\InvalidPaymentTypeException;
use Omnipay\Acapture\Message\CopyAndPay\CheckoutRequest;
use Omnipay\Acapture\Message\CopyAndPay\CheckoutResponse;
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
            ->setInvoiceId('InvoiceIdtest-123')
            ->setPassword($this->password)
            ->setUserId($this->userId)
            ->setEntityId($this->entityId)
            ->setType('DB')
            ->setCurrency('EUR')
            ->setAmount('50.02')
            ->setTransactionId('TransactionIdtest-123');
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
            'paymentType' => 'DB',
            'merchantTransactionId' => 'TransactionIdtest-123',
            'merchantInvoiceId' => 'InvoiceIdtest-123'
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

    public function testGetSetBearer()
    {
        $this->request->setBearer('test123');
        $this->assertSame('test123', $this->request->getBearer());
    }

    public function testGetBearerWithEnv()
    {
        putenv('ACAPTURE_AUTH_BEARER=bearertest123');

        $this->assertSame('bearertest123', $this->request->getBearer());
    }

    public function testGetBearerOverridesWithEnv()
    {
        putenv('ACAPTURE_AUTH_BEARER=bearertest1234');

        $this->request->setBearer('test123');
        $this->assertSame('bearertest1234', $this->request->getBearer());
    }

    public function testGetSetInvoiceId()
    {
        $this->request->setInvoiceId('invoiceId1234');

        $this->assertSame('invoiceId1234', $this->request->getInvoiceId());
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
            '&amount=50.02&currency=EUR&paymentType=DB'.
            '&merchantTransactionId=TransactionIdtest-123&merchantInvoiceId=InvoiceIdtest-123'
            , $this->request->getDataUrl()
        );
    }
}