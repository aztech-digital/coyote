<?php

namespace Aztech\Coyote\Email;

interface Provider
{
    /**
     * Sets the template engine used to render messages.
     *
     * @param TemplateEngine $engine
     */
    public function setTemplateEngine(TemplateEngine $engine);

    /**
     * Sends an email via the provider. Implementations must only call the acceptProvider() method of the message.
     *
     * @param Message $message
     */
    public function send(Message $message);

    /**
     * Renders a message and sends it.
     *
     * @param Message $message
     */
    public function sendMessage(Message $message);

    /**
     * Sends a template message with remote rendering to the provider.
     *
     * @param RemoteTemplateMessage $message
     */
    public function sendRemoteTemplateMessage(RemoteTemplateMessage $message);
}
