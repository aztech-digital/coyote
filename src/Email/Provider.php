<?php

namespace Aztech\Coyote\Email;

interface Provider
{
    /**
     * Sends an email via the provider.
     *
     * @param Message $message
     */
    public function send(Message $message);
}
