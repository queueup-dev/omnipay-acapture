<?php
namespace Omnipay\Acapture;

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
}