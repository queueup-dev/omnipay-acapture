<?php
namespace Omnipay\Acapture\Message\CopyAndPay;

use Guzzle\Http\Exception\ClientErrorResponseException;
use Omnipay\Acapture\Message\AbstractRequest;

class CheckoutStatusRequest extends AbstractRequest
{
    /**
     * Sends supplied data.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     * @param string[] $data
     *
     * @return CheckoutStatusResponse
     */
    public function sendData($data)
    {
        $this->validateRequest();

        try {
            $response = $this->httpClient->get(
                $this->getDataUrl()
            )->send();
        } catch (ClientErrorResponseException $exception) {
            // The 4xx errors are perfectly readable and mappable to a CheckoutStatusResponse.
            $response = $exception->getResponse();
        }

        return new CheckoutStatusResponse($this, json_decode((string)$response->getBody(), true));
    }

    /**
     * Returns the data for this request.
     *
     * @return array
     */
    public function getData()
    {
        return [];
    }

    /**
     * Returns the checkoutId for this request.
     *
     * @return string
     */
    public function getCheckoutId()
    {
        return $this->parameters->get('checkoutId');
    }

    /**
     * Sets the checkoutId for this request.
     *
     * @param string $checkoutId
     */
    public function setCheckoutId($checkoutId)
    {
        $this->parameters->set('checkoutId', $checkoutId);
    }

    /**
     * Validates the request.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function validateRequest()
    {
        parent::validateRequest();

        $this->validate(
            'checkoutId'
        );
    }

    /**
     * Returns the path for this request.
     *
     * @return string
     */
    public function getPath()
    {
        return 'checkouts/' . $this->getCheckoutId() . '/payment';
    }
}