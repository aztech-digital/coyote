<?php

namespace Aztech\Coyote\Tests\Email\Provider;

use Aztech\Coyote\Email\Provider\Mailgun;

class MailgunTest extends \PHPUnit_Framework_TestCase
{

    public function testSendDispatchesToMessage()
    {
        $message = $this->prophesize('Aztech\Coyote\Email\Message');
        $provider = new Mailgun(
            $this->prophesize('\Mailgun\Mailgun')->reveal(),
            'domain.com'
        );

        $message->acceptProvider($provider)->shouldBeCalled();

        $provider->send($message->reveal());
    }

    public function testSendMessageWrapsProviderExceptionInResultObject()
    {

    }
}