<?php
namespace Omnipay\Acapture\Message;

use League\ISO3166\ISO3166;
use Omnipay\Acapture\Common\PaymentBrand;
use Omnipay\Acapture\Common\PaymentType;
use Omnipay\Acapture\Exception\InvalidCountryException;
use Omnipay\Acapture\Exception\InvalidPaymentBrandException;
use Omnipay\Acapture\Exception\InvalidPaymentTypeException;

/**
 * Class PurchaseRequest
 *
 * @package Omnipay\Acapture\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * Returns the request data.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     *
     * @return array|mixed
     */
    public function getData()
    {
        return parent::getData() +  [
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'paymentBrand' => $this->getBrand(),
            'paymentType' => $this->getType(),
            'bankAccount.bankName' => $this->getIssuer(),
            'bankAccount.country' => $this->getCountry(),
            'shopperResultUrl' => $this->getReturnUrl()
        ];
    }

    /**
     * Validates the request.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    protected function validateRequest()
    {
        parent::validateRequest();

        $this->validate(
            'currency',
            'type',
            'brand',
            'country',
            'amount',
            'returnUrl'
        );
    }


    /**
     * Sends supplied data.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     * @param mixed $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     */
    public function sendData($data)
    {
        $this->validateRequest();

        $response = $this->httpClient->post(
            $this->getDataUrl()
        )->send();

        return new PurchaseResponse($this, json_decode((string)$response->getBody(), true));
    }

    /**
     * Sets the brand of the payment method
     *
     * @see PaymentBrand::getPaymentBrands()
     * @param string $brand
     * @throws InvalidPaymentBrandException
     *
     * @return $this|\Omnipay\Common\Message\AbstractRequest
     */
    public function setBrand($brand)
    {
        if (!in_array($brand, PaymentBrand::getPaymentBrands())) {
            throw new InvalidPaymentBrandException(
                'Payment of brand ' . (string)$brand . ' not supported'
            );
        }

        return $this->setParameter('brand', $brand);
    }

    /**
     * Returns the payment brand
     *
     * @see PaymentBrand::getPaymentBrands()
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->getParameter('brand');
    }

    /**
     * Returns the payment brand
     *
     * @see PaymentBrand::getPaymentBrands()
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->getParameter('country');
    }

    /**
     * Sets the country code.
     *
     * @param $country
     *
     * @return $this|\Omnipay\Common\Message\AbstractRequest
     */
    public function setCountry($country)
    {
        try {
            $country = (new ISO3166)->alpha2($country);
        } catch (\Exception $e) { // We don't really care what went wrong
            throw new InvalidCountryException(
                'Supplied country '. $country . ' is invalid alpha2 country or unsupported'
            );
        }

        return $this->setParameter('country', $country['alpha2']);
    }

    /**
     * Sets the type of payment method
     *
     * @see PaymentType::getPaymentTypes()
     * @param string $type
     * @throws InvalidPaymentTypeException
     *
     * @return $this|\Omnipay\Common\Message\AbstractRequest
     */
    public function setType($type)
    {
        if (!in_array($type, PaymentType::getPaymentTypes())) {
            throw new InvalidPaymentTypeException('Payment of type ' . (string)$type . ' not supported');
        }

        return $this->setParameter('type', $type);
    }

    /**
     * Returns the payment type
     *
     * @see PaymentType::getPaymentTypes()
     *
     * @return string
     */
    public function getType()
    {
        return $this->getParameter('type');
    }

    /**
     * Returns the path for this message.
     *
     * @return string
     */
    public function getPath()
    {
        return 'payments';
    }
}