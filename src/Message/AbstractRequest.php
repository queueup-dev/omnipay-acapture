<?php
namespace Omnipay\Acapture\Message;

/**
 * Class AbstractRequest
 *
 * @package Omnipay\Acapture\Message
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Initializes the client.
     *
     * @param array $parameters
     *
     * @return $this|\Omnipay\Common\Message\AbstractRequest
     */
    public function initialize(array $parameters = array())
    {
        parent::initialize($parameters);

        $this->httpClient->setBaseUrl($this->getEndpoint());

        return $this;
    }

    /**
     * Returns the request data.
     *
     * @return array|mixed
     */
    public function getData()
    {
        return [
            'authentication.userId' => $this->getUserId(),
            'authentication.password' => $this->getPassword(),
            'authentication.entityId' => $this->getEntityId()
        ];
    }

    /**
     * Returns the data as URL.
     *
     * @return string
     */
    public function getDataUrl()
    {
        return $this->getPath() . '?' . http_build_query($this->getData());
    }

    /**
     * Validates the request.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    protected function validateRequest()
    {
        $this->validate(
            'userId',
            'password',
            'entityId'
        );
    }

    /**
     * Sets the userId
     *
     * @param $userId
     *
     * @return $this|\Omnipay\Common\Message\AbstractRequest
     */
    public function setUserId($userId)
    {
        return $this->setParameter('userId', (string)$userId);
    }

    /**
     * Returns the userId
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->getParameter('userId');
    }

    /**
     * Sets the password
     *
     * @param $password
     *
     * @return $this|\Omnipay\Common\Message\AbstractRequest
     */
    public function setPassword($password)
    {
        return $this->setParameter('password', (string)$password);
    }

    /**
     * Returns the password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Sets the entityId
     *
     * @param $entityId
     *
     * @return $this|\Omnipay\Common\Message\AbstractRequest
     */
    public function setEntityId($entityId)
    {
        return $this->setParameter('entityId', $entityId);
    }

    /**
     * Returns the entityId
     *
     * @return string
     */
    public function getEntityId()
    {
        return $this->getParameter('entityId');
    }

    /**
     * Returns the Acapture endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return (getenv('ACAPTURE_ENDPOINT') ?: 'https://test.acaptureservices.com/v1/');
    }

    public abstract function getPath();
}