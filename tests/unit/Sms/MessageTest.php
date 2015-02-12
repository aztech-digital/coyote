<?php

namespace Aztech\Coyote\Tests\Sms;

use Aztech\Coyote\Sms\Message;
use Aztech\Coyote\Sms\PhoneNumber;

class MessageTest extends \PHPUnit_Framework_TestCase
{

    public function testGetRecipientsReturnsEmptyCollectionByDefault()
    {
        $message = new Message('');

        $this->assertEmpty($message->getRecipients());
    }

    public function testWhenARecipientIsAddedByConstructorGetReipientsContainsIt()
    {
        $recipient = new PhoneNumber('33', '00000000');
        $message = new Message('', $recipient);

        $this->assertContains($recipient, $message->getRecipients());
    }

    public function testWhenARecipientIsAddedGetReipientsContainsIt()
    {
        $message = new Message('');
        $recipient = new PhoneNumber('33', '00000000');

        $message->addRecipient($recipient);

        $this->assertContains($recipient, $message->getRecipients());
    }
}
