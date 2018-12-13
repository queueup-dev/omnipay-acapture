<?php
namespace Omnipay\Acapture\Tests\Message;

use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Omnipay\Acapture\Message\CopyAndPay\CheckoutStatusRequest;
use Omnipay\Acapture\Message\CopyAndPay\CheckoutStatusResponse;
use Omnipay\Tests\TestCase;

class CheckoutStatusRequestTest extends TestCase
{
    /**
     * @var CheckoutStatusRequest
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

        $this->request = new CheckoutStatusRequest($mockClient, $this->getHttpRequest());
        $this->request->initialize();

        $this->password = uniqid('', true);
        $this->entityId = uniqid('', true);
        $this->userId = uniqid('', true);
    }

    public function testGetCheckoutIdEmpty()
    {
        $this->assertSame(null, $this->request->getCheckoutId());
    }

    public function testGetPathWithoutCheckoutId()
    {
        $this->assertSame('checkouts//payment', $this->request->getPath());
    }

    public function testGetCheckoutId()
    {
        $this->request->setCheckoutId('test123');
        $this->assertSame('test123', $this->request->getCheckoutId());
    }

    public function testGetPath()
    {
        $this->request->setCheckoutId('1234');
        $this->assertSame('checkouts/1234/payment', $this->request->getPath());
    }

    public function testSendRequest()
    {
        $this->request
            ->setPassword($this->password)
            ->setUserId($this->userId)
            ->setEntityId($this->entityId)
            ->setCheckoutId('test-12345');

        $this->assertInstanceOf(CheckoutStatusResponse::class, $this->request->send());
    }
}