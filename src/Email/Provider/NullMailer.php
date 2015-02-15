<?php

namespace Aztech\Coyote\Email\Provider;

use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\Provider;
use Aztech\Coyote\Email\RecipientStatusCollection;
use Aztech\Coyote\Email\RemoteTemplateMessage;

class NullMailer implements Provider
{
    use ProviderTrait;

    public function sendMessage(Message $message)
    {
        $status = new RecipientStatusCollection();

        $status->addMessageStatus($message, true);
    }

    public function sendRemoteTemplateMessage(RemoteTemplateMessage $message)
    {
        return $this->sendMessage($message);
    }
}
