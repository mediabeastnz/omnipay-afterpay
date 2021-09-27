# Omnipay: AfterPay

**AfterPay driver for the Omnipay PHP payment processing library**

[![Latest Stable Version](https://poser.pugx.org/mediabeastnz/omnipay-afterpay/v/stable)](https://packagist.org/packages/mediabeastnz/omnipay-afterpay)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements common classes required by Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "mediabeastnz/omnipay-afterpay": "~3.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Quirks

- User Agent is required by Afterpay
- Country code should be set when afterpayjs is initialized


## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/mediabestnz/omnipay-afterpay/issues),
or better yet, fork the library and submit a pull request.
