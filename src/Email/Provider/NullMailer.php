<?php

namespace Aztech\Coyote\Email\Provider;

use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\Provider;
use Aztech\Coyote\Email\RemoteTemplateMessage;

class NullMailer implements Provider
{
    use ProviderTrait;

    public function sendMessage(Message $message)
    {

    }

    public function sendRemoteTemplateMessage(RemoteTemplateMessage $message)
    {

    }
}
