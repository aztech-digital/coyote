<?php

namespace Aztech\Coyote\Sms\Provider;

use Aztech\Coyote\Sms\Message;
use Aztech\Coyote\Sms\Provider;

class NullProvider implements Provider
{
    public function send(Message $message)
    {

    }
}
