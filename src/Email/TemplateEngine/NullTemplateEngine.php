<?php

namespace Aztech\Coyote\Email\TemplateEngine;

use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\TemplateEngine;

class NullTemplateEngine implements TemplateEngine
{
    public function render(Message $message)
    {
        return $message->getBody();
    }
}
