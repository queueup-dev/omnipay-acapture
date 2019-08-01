<?php
namespace Omnipay\Acapture\Message\CopyAndPay;

use Omnipay\Acapture\Common\PaymentType;
use Omnipay\Acapture\Exception\InvalidPaymentTypeException;
use Omnipay\Acapture\Message\AbstractRequest;

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
            'paymentType' => $this->getType(),
            'merchantTransactionId' => $this->getTransactionId(),
            'merchantInvoiceId' => $this->getInvoiceId()
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

        $request = $this->httpClient->post(
            $this->getDataUrl()
        );

        if ($this->getBearer()) {
            $request->addHeader('Authorization', 'Bearer ' . $this->getBearer());
        }

        $response = $request->send();

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
     * Sets the merchant invoice Id
     *
     * @param string $invoiceId
     *
     * @return $this|\Omnipay\Common\Message\AbstractRequest
     */
    public function setInvoiceId($invoiceId)
    {
        return $this->setParameter('invoiceId', $invoiceId);
    }

    /**
     * Returns the merchant invoice Id
     *
     * @return mixed
     */
    public function getInvoiceId()
    {
        return $this->getParameter('invoiceId');
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