<?php
namespace Omnipay\Acapture\Common;

/**
 * Class ResultCodes
 *
 * @package Omnipay\Acapture\Common
 *
 * @see https://docs.acaptureservices.com/reference/resultCodes
 */
abstract class ResultCode
{
    /**
     * Success statuses - Should be considered successful
     *
     * @param $code
     *
     * @return bool
     */
    public static function isSuccess($code)
    {
        return (bool)
            preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $code);
    }

    /**
     * These responses indicate that the transaction should be manually checked.
     *
     * @param $code
     *
     * @return bool
     */
    public static function isManualCheck($code)
    {
        return (bool)
            preg_match('/^(000\.400\.0[^3]|000\.400\.100)/', $code);
    }

    /**
     * Pending statuses - Should resolve status soon.
     *
     * @param $code
     *
     * @return bool
     */
    public static function isPending($code)
    {
        return (bool)
            (
                preg_match('/^(000\.200)/', $code) ||
                preg_match('/^(800\.400\.5|100\.400\.500)/', $code)
            );
    }

    /**
     * Rejected related statuses.
     *
     * @param $code
     *
     * @return bool
     */
    public static function isRejected($code)
    {
        return (bool)
        (
            preg_match('/^(000\.400\.[1][0-9][1-9]|000\.400\.2)/', $code) ||
            preg_match('/^(800\.[17]00|800\.800\.[123])/', $code) ||
            preg_match('/^(900\.[1234]00|000\.400\.030)/', $code) ||
            preg_match('/^(800\.5|999\.|600\.1|800\.800\.8)/', $code) ||
            preg_match('/^(100\.39[765])/', $code) ||
            preg_match('/^(100\.400|100\.38|100\.370\.100|100\.370\.11)/', $code) ||
            preg_match('/^(800\.400\.1)/', $code) ||
            preg_match('/^(800\.400\.2|100\.380\.4|100\.390)/', $code) ||
            preg_match('/^(100\.100\.701|800\.[32])/', $code) ||
            preg_match('/^(800\.1[123456]0)/', $code) ||
            preg_match('/^(600\.[23]|500\.[12]|800\.121)/', $code) ||
            preg_match('/^(100\.[13]50)/', $code) ||
            preg_match('/^(100\.250|100\.360)/', $code) ||
            preg_match('/^(700\.[1345][05]0)/', $code) ||
            preg_match('/^(200\.[123]|100\.[53][07]|800\.900|100\.[69]00\.500)/', $code) ||
            preg_match('/^(100\.800)/', $code) ||
            preg_match('/^(100\.55)/', $code) ||
            preg_match('/^(100\.[97]00)/', $code) ||
            preg_match('/^(100\.100|100.2[01])/', $code) ||
            preg_match('/^(100\.380\.[23]|100\.380\.101)/', $code)
        );
    }

    /**
     * Chargeback related statuses.
     *
     * @param $code
     *
     * @return false|int
     */
    public static function isChargeback($code)
    {
        return (bool)
            preg_match('/^(000\.100\.2)/', $code);
    }
}