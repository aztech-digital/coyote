<?php

namespace Aztech\Coyote\Sms;

interface MessageGateway
{
    public function send(Message $message);
}
