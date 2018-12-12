<?php
namespace Omnipay\Acapture\Tests\Message;

use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Omnipay\Acapture\Message\PaymentStatusRequest;
use Omnipay\Acapture\Message\PaymentStatusResponse;
use Omnipay\Tests\TestCase;

class PaymentStatusRequestTest extends TestCase
{
    /**
     * @var PaymentStatusRequest
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
        \Phake::when($mockClient)->get(\Phake::anyParameters())->thenReturn($clientInterface);

        $this->request = new PaymentStatusRequest($mockClient, $this->getHttpRequest());
        $this->request->initialize();

        $this->password = uniqid('', true);
        $this->entityId = uniqid('', true);
        $this->userId = uniqid('', true);
    }

    public function testGetPaymentIdEmpty()
    {
        $this->assertSame(null, $this->request->getPaymentId());
    }

    public function testGetPathWithoutPaymentId()
    {
        $this->assertSame('payments/', $this->request->getPath());
    }

    public function testGetSetPaymentId()
    {
        $this->request->setPaymentId('test123');
        $this->assertSame('test123', $this->request->getPaymentId());
    }

    public function testGetPath()
    {
        $this->request->setPaymentId('1234');
        $this->assertSame('payments/1234', $this->request->getPath());
    }

    public function testSendRequest()
    {
        $this->request
            ->setPassword($this->password)
            ->setUserId($this->userId)
            ->setEntityId($this->entityId)
            ->setPaymentId('test-12345');

        $this->assertInstanceOf(PaymentStatusResponse::class, $this->request->send());
    }
}