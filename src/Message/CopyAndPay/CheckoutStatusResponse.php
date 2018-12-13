<?php
namespace Omnipay\Acapture\Message\CopyAndPay;

use Omnipay\Acapture\Common\ResultCode;
use Omnipay\Acapture\Message\AbstractResponse;

class CheckoutStatusResponse extends AbstractResponse
{
    /**
     * Returns whether or not the payment was successful.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return ResultCode::isSuccess(
            $this->getParameter('result.code')
        );
    }

    /**
     * Returns whether or not the payment is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return ResultCode::isPending(
            $this->getParameter('result.code')
        );
    }

    /**
     * Retrieves the result code.
     *
     * @return string|null
     */
    public function getResultCode()
    {
        return $this->getParameter('result.code');
    }

    /**
     * Returns the description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getParameter('result.description');
    }

    /**
     * Returns the checkout id (ndc)
     *
     * @return string|null
     */
    public function getCheckoutId()
    {
        return $this->getParameter('ndc');
    }
}