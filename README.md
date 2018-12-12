# Omnipay: PayVision/Acapture
![Build Status](https://scrutinizer-ci.com/g/queueup-dev/omnipay-acapture/badges/build.png?b=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/queueup-dev/omnipay-acapture/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/queueup-dev/omnipay-acapture/)
[![Code Coverage](https://scrutinizer-ci.com/g/queueup-dev/omnipay-acapture/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/queueup-dev/omnipay-acapture/?branch=master)

**acapture gateway integration for for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements [acapture](https://www.acapture.com/) support for Omnipay.

## Installation
To install you can [composer](http://getcomposer.org/) require the package;

```
$ composer require qup/omnipay-acapture
```

You can also include the package directly in the `composer.json` file
```
{
    "require": {
        "qup/omnipay-acapture": "^1.0"
    }
}
```

## Usage

### Creating the gateway
To create the Acapture gateway you can use the code below;
```
$gateway = \Omnipay::create('Acapture');

$gateway
    ->setPassword('yourpassword')
    ->setUserId('youruserid')
    ->setEntityId('yourentityid');
```
### Creating a payment
Once you have setup the gateway you can create a PaymentRequest;
```
$purchaseRequest = $gateway->purchase();
$purchaseRequest
    ->setCountry('NL')
    ->setReturnUrl('https://your-return-url.cc/payment-status')
    ->setType(PaymentType::PAYMENT_TYPE_DB)
    ->setIssuer(PaymentBrand::PAYMENT_BRAND_IDEAL)
    ->setCurrency('EUR')
    ->setAmount('5.00');
    
$response = $purchaseRequest->send();
```
### Checking payment status
After the payment request has been made you can check on the status;
```
$statusRequest = $gateway->paymentStatus('yourPayId');
$response = $statusRequest->send();
```