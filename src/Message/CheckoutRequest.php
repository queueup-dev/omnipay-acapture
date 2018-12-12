<?php
namespace Omnipay\Acapture\Message;

use Omnipay\Acapture\Common\PaymentType;
use Omnipay\Acapture\Exception\InvalidPaymentTypeException;

class CheckoutRequest extends AbstractRequest
{
    /**
     * Returns the request data.
     *
     * @return array|mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        return parent::getData() + [
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'paymentType' => $this->getType()
        ];
    }

    /**
     * Sends supplied data.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     * @param mixed $data
     *
     * @return CheckoutResponse
     */
    public function sendData($data)
    {
        $this->validateRequest();

        $response = $this->httpClient->post(
            $this->getDataUrl()
        )->send();

        return new CheckoutResponse($this, json_decode((string)$response->getBody(), true));
    }

    public function validateRequest()
    {
        parent::validateRequest();

        $this->validate(
            'amount',
            'currency',
            'type'
        );
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
     * Returns the path for this request.
     *
     * @return string
     */
    public function getPath()
    {
        return 'checkouts';
    }
}