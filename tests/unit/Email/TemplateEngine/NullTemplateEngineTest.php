<?php

namespace Aztech\Coyote\Tests\Email\TemplateEngine;

use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\TemplateEngine\NullTemplateEngine;

class NullTemplateEngineTest extends \PHPUnit_Framework_TestCase
{
    public function testBodyWithPlaceholderIsRenderedWithMatchingValue()
    {
        $message = new Message();

        $message->setBody('Hello {{ test }}, how are you {{day}} ?');
        $message->setVariable('day', 'on this fine day');
        $message->setVariable('test', 'value');

        $templateEngine = new NullTemplateEngine();

        $this->assertEquals('Hello {{ test }}, how are you {{day}} ?', $templateEngine->render($message));
    }

    public function testBodyWithPlaceholderIsRenderedWithMatchingValue2()
    {
        $message = new Message();

        $message->setBody('Hello {{ test }}, how are you {{day}} ?');
        $message->setVariables([
            'day' => 'on this fine day',
            'test' => 'value'
        ]);

        $templateEngine = new NullTemplateEngine();

        $this->assertEquals('Hello {{ test }}, how are you {{day}} ?', $templateEngine->render($message));
    }
}