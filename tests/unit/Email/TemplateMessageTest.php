<?php

namespace Aztech\Coyote\Tests\Email;

use Aztech\Coyote\Email\TemplateMessage;

class TemplateMessageTest extends \PHPUnit_Framework_TestCase
{
    public function testBodyWithPlaceholderIsRenderedWithMatchingValue()
    {
        $message = new TemplateMessage();
        $message->setBody('Hello {{ test }}, how are you {{day}} ?');
        
        $message->setVariable('day', 'on this fine day');
        $message->setVariable('test', 'value');
        
        $this->assertEquals('Hello value, how are you on this fine day ?', $message->getBody());
    }
    
    public function testBodyWithPlaceholderIsRenderedWithMatchingValue2()
    {
        $message = new TemplateMessage();
        $message->setBody('Hello {{ test }}, how are you {{day}} ?');
    
        $message->setVariables([
            'day' => 'on this fine day',
            'test' => 'value'
        ]);
    
        $this->assertEquals('Hello value, how are you on this fine day ?', $message->getBody());
    }
}