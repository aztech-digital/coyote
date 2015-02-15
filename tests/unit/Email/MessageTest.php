<?php

namespace Aztech\Coyote\Tests\Email;

use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\Address;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSenderReturnsSetSender()
    {
        $message = new Message();
        $sender = new Address("test@domain.com", "Name");
        
        $message->setSender($sender);
        
        $this->assertEquals($sender, $message->getSender());
    }
    
    public function testGetSubjectReturnsSetSubject()
    {
        $message = new Message();
        $subject = "Subject";
        
        $message->setSubject($subject);
        
        $this->assertEquals($subject, $message->getSubject());
    }
    
    public function testGetBodyReturnsSetBody()
    {
        $message = new Message();
        $body = "Message body";
        
        $message->setBody($body);
        
        $this->assertEquals($body, $message->getBody());
        $this->assertFalse($message->isHtmlMessage());
    }

    public function testGetBodyReturnsSetHtmlBody()
    {
        $message = new Message();
        $body = "<p>Message body</p>";
    
        $message->setHtmlBody($body);
    
        $this->assertEquals($body, $message->getBody());
        $this->assertTrue($message->isHtmlMessage());
    }
}