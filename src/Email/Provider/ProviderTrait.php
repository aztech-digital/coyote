<?php

namespace Aztech\Coyote\Email\Provider;

use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\TemplateEngine;

trait ProviderTrait
{
    private $templateEngine;

    public function setTemplateEngine(TemplateEngine $engine)
    {
        $this->templateEngine;
    }

    protected function renderMessage(Message $message)
    {
        return $this->templateEngine->renderMessage($message);
    }

    public function send(Message $message)
    {
        return $message->acceptProvider($this);
    }
}
