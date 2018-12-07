<?php
namespace Omnipay\Acapture\Common;

abstract class PaymentBrand
{
    const PAYMENT_BRAND_IDEAL = 'IDEAL';

    /**
     * Returns a list of payment brands.
     *
     * @return string[]
     */
    public static function getPaymentBrands()
    {
        return [
            self::PAYMENT_BRAND_IDEAL
        ];
    }
}