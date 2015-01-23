<?php

namespace Aztech\Coyote;

interface Mailer
{

    function send(Message $message);
}
