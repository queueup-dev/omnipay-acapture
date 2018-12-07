<?php
namespace Omnipay\Acapture\Common;

abstract class PaymentType
{
    const PAYMENT_TYPE_DB = 'DB';
    const PAYMENT_TYPE_PA = 'PA';

    /**
     * Returns all payment types.
     *
     * @return array
     */
    public static function getPaymentTypes()
    {
        return [
            self::PAYMENT_TYPE_DB,
            self::PAYMENT_TYPE_PA
        ];
    }
}