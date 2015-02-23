<?php

namespace Aztech\Coyote\Email\Provider;

use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\TemplateEngine;
use Aztech\Coyote\Email\RecipientStatusCollection;

trait ProviderTrait
{
    private $templateEngine;

    public function setTemplateEngine(TemplateEngine $engine)
    {
        $this->templateEngine;
    }

    protected function renderMessage(Message $message)
    {
        return $this->templateEngine->render($message);
    }

    /**
     *
     * @param Message $message
     * @return RecipientStatusCollection
     */
    public function send(Message $message)
    {
        return $message->acceptProvider($this);
    }
}
