# coyote

[![Build Status](https://travis-ci.org/aztech-digital/coyote.png?branch=master)](https://travis-ci.org/aztech-digital/coyote)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/coverage/g/aztech-digital/coyote.svg?style=flat)](https://scrutinizer-ci.com/g/aztech-digital/coyote/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/g/aztech-digital/coyote.svg?style=flat)](https://scrutinizer-ci.com/g/aztech-digital/coyote/?branch=master)
[![HHVM Support](https://img.shields.io/hhvm/aztech/coyote.svg)](http://hhvm.h4cc.de/package/aztech/coyote)

[![License](https://img.shields.io/packagist/l/aztech/coyote.svg?style=flat)](https://packagist.org/packages/aztech/coyote)
[![Latest Stable Version](https://img.shields.io/packagist/v/aztech/coyote.svg?style=flat)](https://packagist.org/packages/aztech/coyote)

Coyote is a library to send emails and text messages with support for multiple provides

## Setup

[Composer](https://getcomposer.org) is the only supported way of installing Coyote. From the root of your project, run the following command:

```
composer require aztech/coyote
```

## Features

- Send transactional emails
- Build messages using local or remote (ie. Mandrill/Mailchimp templates) message templates
- Send text messages
- Optional integration with [Phinject](https://github.com/aztech-digital/phinject) DI container

## Usage

### Send emails

```php

use \Aztech\Coyote\Email\Address;
use \Aztech\Coyote\Email\Message;
use \Aztech\Coyote\Email\Provider\MailgunFactory;

require_once 'vendor/autoload.php';

$factory = new MailgunFactory();
$provider = $factory->buildProvider([
    'key' => 'MAILGUN_APIKEY',
    'domain' => 'mydomain.com'
]);

$message = new \Aztech\Coyote\Email\Message();

$message->addRecipient(new Address('email@domain.com');
$message->setTitle('News');
$message->setBody('Hello, how are you ?');

$provider->send($message);
```