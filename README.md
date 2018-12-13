# Omnipay: PayVision/Acapture
**acapture gateway integration for for the Omnipay PHP payment processing library**

## Introduction
![Build Status](https://scrutinizer-ci.com/g/queueup-dev/omnipay-acapture/badges/build.png?b=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/queueup-dev/omnipay-acapture/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/queueup-dev/omnipay-acapture/)
[![Code Coverage](https://scrutinizer-ci.com/g/queueup-dev/omnipay-acapture/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/queueup-dev/omnipay-acapture/?branch=master)
[![Total Downloads](https://poser.pugx.org/qup/omnipay-acapture/d/total)](https://packagist.org/packages/qup/omnipay-acapture)

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
### Creating a payment (server-to-server)
This payment requests requires you to be PCI compliant for credit cards.
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
### Checking payment status (server-to-server)
After the payment request has been made you can check on the status;
```
$statusRequest = $gateway->paymentStatus('yourPayId');
$response = $statusRequest->send();
```
### Create a payment (embedded)
This payment request does not require compliance but requires web embedding.
```
$embedRequest = $gateway->embed();
$embedRequest
    ->setType(PaymentType::PAYMENT_TYPE_DB)
    ->setCurrency('EUR')
    ->setAmount('5.00');
    
$response = $embedRequest->send();
```
Embedding can be done on the front-end using the following code;
```
<script src="{$response->getEmbedUrl()}"></script>
<form action="{shopperResultUrl}" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
```
for more information see the [acapture documentation](https://docs.acaptureservices.com/tutorials/integration-guide).

### Checking payment status (embedded)
After the checkout request has been made you can check on it's status:
```
$statusRequest = $gateway->checkoutStatus('yourCheckoutId');
$response = $statusRequest->send();
```
