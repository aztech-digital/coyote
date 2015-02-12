<?php

namespace Aztech\Coyote\Tests\ServiceProvider;

use Aztech\Phinject\ContainerFactory;

class PhinjectTest extends \PHPUnit_Framework_TestCase
{
    public function testActivatorReturnsMailProvider()
    {
        $yaml = <<<YML
config:
    activators:
        coyote:
            class: \Aztech\Coyote\ServiceProvider\Phinject

classes:
    emailService:
        coyote:
            type: email
            provider: mailgun
        mailgun:
            key: apikey
            domain: localhost.dev
            ssl: true
YML;

        $container = ContainerFactory::createFromInlineYaml($yaml);
        $service = $container->get('emailService');

        $this->assertInstanceOf('\Aztech\Coyote\EmailService', $service);
        $this->assertInstanceOf('\Aztech\Coyote\Email\Provider\Mailgun', $service->getProvider());
    }

    public function testActivatorReturnsSmsProvider()
    {
        $yaml = <<<YML
config:
    activators:
        coyote:
            class: \Aztech\Coyote\ServiceProvider\Phinject

classes:
    smsService:
        coyote:
            type: sms
            provider: twilio
        twilio:
            key: accountSid
            token: authToken
            sender:
                number: 9194561223
                country: US
YML;

        $container = ContainerFactory::createFromInlineYaml($yaml);
        $service = $container->get('smsService');

        $this->assertInstanceOf('\Aztech\Coyote\SmsService', $service);
        $this->assertInstanceOf('\Aztech\Coyote\Sms\Provider\Twilio', $service->getProvider());
    }
}