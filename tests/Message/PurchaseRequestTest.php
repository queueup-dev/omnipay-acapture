<?php
namespace Omnipay\Acapture\Tests\Message;

use Mockery\Mock;
use Omnipay\Acapture\Exception\InvalidCountryException;
use Omnipay\Acapture\Exception\InvalidPaymentBrandException;
use Omnipay\Acapture\Exception\InvalidPaymentTypeException;
use Omnipay\Acapture\Message\PurchaseRequest;
use Omnipay\Acapture\Message\PurchaseResponse;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var Mock|PurchaseRequest
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
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize();

        $this->password = uniqid('', true);
        $this->entityId = uniqid('', true);
        $this->userId = uniqid('', true);
    }

    public function paymentBrands()
    {
        return [
            ["IDEAL"]
        ];
    }

    public function paymentTypes()
    {
        return [
            ["DB"],
            ["PA"]
        ];
    }

    public function testGetBrandEmpty()
    {
        $this->assertSame(null, $this->request->getBrand());
    }

    public function testGetTypeEmpty()
    {
        $this->assertSame(null, $this->request->getType());
    }

    public function testGetCountryEmpty()
    {
        $this->assertSame(null, $this->request->getCountry());
    }

    public function testSetBrandUsingInvalidBrand()
    {
        $this->setExpectedException(InvalidPaymentBrandException::class, 'Payment of brand bla not supported');
        $this->request->setBrand('bla');
    }

    /**
     * @param $paymentBrand
     * @dataProvider paymentBrands
     */
    public function testGetSetBrandUsingValidBrands($paymentBrand)
    {
        $this->request->setBrand($paymentBrand);
        $this->assertSame($paymentBrand, $this->request->getBrand());
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

    public function testSetCountryWithValidAlpha2()
    {
        $this->request->setCountry('NL');
        $this->assertSame('NL', $this->request->getCountry());
    }

    public function testSetCountryWithValidAlpha3()
    {
        $this->setExpectedException(InvalidCountryException::class, 'Supplied country NLD is invalid alpha2 country or unsupported');
        $this->request->setCountry('NLD');
    }

    public function testSetCountryWithInvalidAlpha3()
    {
        $this->setExpectedException(InvalidCountryException::class, 'Supplied country LLL is invalid alpha2 country or unsupported');
        $this->request->setCountry('LLL');
    }

    public function testGetPathReturnsRightPath()
    {
        $this->assertSame('payments', $this->request->getPath());
    }

    public function setMockRequestData()
    {
        $this->request
            ->setPassword($this->password)
            ->setUserId($this->userId)
            ->setEntityId($this->entityId)
            ->setType('DB')
            ->setBrand('IDEAL')
            ->setCountry('NL')
            ->setCurrency('EUR')
            ->setAmount('50.02')
            ->setIssuer('TESTBANK')
            ->setNotifyUrl('https://test.test/notify');
    }

    public function testGetData()
    {
        $this->setMockRequestData();

        $expectedData = [
            'authentication' => [
                'userId' => $this->userId,
                'password' => $this->password,
                'entityId' => $this->entityId
            ],
            'amount' => '50.02',
            'currency' => 'EUR',
            'paymentBrand' => 'IDEAL',
            'paymentType' => 'DB',
            'bankAccount' => [
                'bankName' => 'TESTBANK',
                'country' => 'NL'
            ],
            'shopperResultUrl' => 'https://test.test/notify'
        ];

        $data = $this->request->getData();
        $this->assertSame($expectedData, $data);
    }

    public function testSendWithValidData()
    {
        $this->setMockRequestData();
        $this->assertInstanceOf(PurchaseResponse::class, $this->request->send());
    }
}