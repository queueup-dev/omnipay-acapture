<?php
namespace Omnipay\Acapture\Message;

/**
 * Class PaymentStatusRequest
 *
 * @package Omnipay\Acapture\Message
 */
class PaymentStatusRequest extends AbstractRequest
{
    /**
     * Validates the request.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    protected function validateRequest()
    {
        parent::validateRequest();

        $this->validate(
            'paymentId'
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
    public function sendData($data = [])
    {
        $this->validateRequest();

        $response = $this->httpClient->post(
            $this->getDataUrl()
        )->send();

        return new PaymentStatusResponse($this, json_decode((string)$response->getBody(), true));
    }

    /**
     * Sets the paymentId of the request.
     *
     * @param $paymentId
     */
    public function setPaymentId($paymentId)
    {
        $this->setParameter('paymentId', $paymentId);
    }

    /**
     * Returns the paymentId
     *
     * @return string
     */
    public function getPaymentId()
    {
        return $this->getParameter('paymentId');
    }

    /**
     * Returns the path of this request.
     *
     * @return string
     */
    public function getPath()
    {
        return 'payments/' . $this->getPaymentId();
    }
}