<?php

namespace Aztech\Coyote\Email\Provider;

use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\Provider;

class NullMailer implements Provider
{
    public function send(Message $message)
    {

    }
}
