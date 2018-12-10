<?php
namespace Omnipay\Acapture\Message;

use Omnipay\Acapture\Common\ResultCode;

class PaymentStatusResponse extends AbstractResponse
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
     * Returns the transaction id (ndc)
     *
     * @return string|null
     */
    public function getTransactionId()
    {
        return $this->getParameter('ndc');
    }
}