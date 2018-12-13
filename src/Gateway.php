<?php
namespace Omnipay\Acapture;

use Omnipay\Acapture\Message\CopyAndPay\CheckoutRequest;
use Omnipay\Acapture\Message\CopyAndPay\CheckoutStatusRequest;
use Omnipay\Acapture\Message\ServerToServer\PaymentStatusRequest;
use Omnipay\Acapture\Message\ServerToServer\PurchaseRequest;
use Omnipay\Common\AbstractGateway;

/**
 * Class Gateway
 * @package Omnipay\Acapture
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'acapture';
    }

    /**
     * Creates a server-to-server purchase request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest|CheckoutRequest
     */
    public function purchase($parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * Creates a embed purchase request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest|CheckoutRequest
     */
    public function embed($parameters = array())
    {
        return $this->createRequest(CheckoutRequest::class, $parameters);
    }

    /**
     * Creates an checkout status request.
     *
     * @param $checkoutId
     *
     * @return \Omnipay\Common\Message\AbstractRequest|CheckoutStatusRequest
     */
    public function checkoutStatus($checkoutId)
    {
        $data = ['checkoutId' => $checkoutId];
        return $this->createRequest(CheckoutStatusRequest::class, $data);
    }

    /**
     * @param $paymentId
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function paymentStatus($paymentId)
    {
        $data = ['paymentId' => $paymentId];
        return $this->createRequest(PaymentStatusRequest::class, $data);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->getParameter('userId');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setUserId($value)
    {
        return $this->setParameter('userId', $value);
    }

    /**
     * @return string
     */
    public function getEntityId()
    {
        return $this->getParameter('entityId');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setEntityId($value)
    {
        return $this->setParameter('entityId', $value);
    }
}