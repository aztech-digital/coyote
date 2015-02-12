<?php

namespace Aztech\Coyote\Sms;

interface Provider
{
    public function send(Message $message);
}
