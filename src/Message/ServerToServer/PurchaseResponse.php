<?php
namespace Omnipay\Acapture\Message\ServerToServer;

use Omnipay\Acapture\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Class PurchaseResponse
 *
 * @package Omnipay\Acapture\Message
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Returns the externalId from acapture.
     *
     * @return string|null
     */
    public function getExternalId()
    {
        return $this->getParameter('id');
    }

    /**
     * Returns the amount
     *
     * @return string|null
     */
    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    /**
     * Retrieves the currency.
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    /**
     * Returns the redirect data.
     *
     * @return array
     */
    public function getRedirectData()
    {
        return $this->getData();
    }

    /**
     * Returns the redirect method.
     *
     * @return string|null
     */
    public function getRedirectMethod()
    {
        return $this->getParameter('redirect.method', 'GET');
    }

    /**
     * Returns whether or not the payment was successful.
     * For acapture we always redirect to the PSP page, so this is always false
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * Returns whether or not it's a redirect request, which is clear the case.
     *
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * Returns the redirect URL.
     *
     * @return string|null
     */
    public function getRedirectUrl()
    {
        return $this->getParameter('redirect.url');
    }
}