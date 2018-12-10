<?php
namespace Omnipay\Acapture;

use Omnipay\Acapture\Message\AbstractRequest;
use Omnipay\Acapture\Message\PurchaseRequest;
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
     * @param array $parameters
     *
     * @return AbstractRequest|PurchaseRequest
     */
    public function purchase($parameters = array())
    {
        return $this->createRequest('\Omnipay\Acapture\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param $paymentId
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function paymentStatus($paymentId)
    {
        $data = ['paymentId' => $paymentId];
        return $this->createRequest('\Omnipay\Acapture\Message\PaymentStatusRequest', $data);
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