<?php
namespace Omnipay\Acapture\Message;

use Omnipay\Acapture\Common\RetrieveParameters;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    use RetrieveParameters;

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
    }
}