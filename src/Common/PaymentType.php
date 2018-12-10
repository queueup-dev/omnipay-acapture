<?php
namespace Omnipay\Acapture\Common;

abstract class PaymentType
{
    const PAYMENT_TYPE_DB = 'DB';
    const PAYMENT_TYPE_PA = 'PA';
    const PAYMENT_TYPE_CD = 'CD';
    const PAYMENT_TYPE_CP = 'CP';
    const PAYMENT_TYPE_RV = 'RV';
    const PAYMENT_TYPE_RF = 'RF';

    /**
     * Returns all payment types.
     *
     * @return array
     */
    public static function getPaymentTypes()
    {
        return [
            self::PAYMENT_TYPE_DB,
            self::PAYMENT_TYPE_PA,
            self::PAYMENT_TYPE_CD,
            self::PAYMENT_TYPE_CP,
            self::PAYMENT_TYPE_RV,
            self::PAYMENT_TYPE_RF
        ];
    }
}