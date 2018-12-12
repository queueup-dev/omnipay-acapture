<?php
namespace Omnipay\Acapture\Message;

class CheckoutResponse extends AbstractResponse
{
    /**
     * Returns whether or not the payment was successful.
     * This can never be the case on a CreateCheckout call.
     *
     * @return false
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * Returns the checkoutId.
     *
     * @return string|null
     */
    public function getCheckoutId()
    {
        return $this->getParameter('id');
    }

    /**
     * Returns the embedPath.
     *
     * @return string
     */
    public function getEmbedPath()
    {
        return (getenv('ACAPTURE_EMBED_PATH') ?: 'https://test.acaptureservices.com/v1/paymentWidgets.js');
    }

    /**
     * Returns the embed url for this request.
     *
     * @return string
     */
    public function getEmbedUrl()
    {
        return $this->getEmbedPath() . '?' . http_build_query(['checkoutId' => $this->getCheckoutId()]);
    }
}