<?php

namespace Aztech\Coyote;

use Aztech\Coyote\Email\Address;
use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\Provider;
use Aztech\Coyote\Email\Provider\NullMailer;

class EmailService
{
    private $mailer;

    public function __construct(Provider $mailer = null)
    {
        $this->mailer = $mailer ?: new NullMailer();
    }

    /**
     *
     * @return Provider
     */
    public function getProvider()
    {
        return $this->mailer;
    }

    public function sendMessage(Message $message)
    {
        return $this->mailer->send($message);
    }

    public function sendRaw($from, $to, $body, array $cc = [], array $bcc = [])
    {
        $message = new Message();

        $message->setSender(new Address($from));
        $message->addRecipient($to);
        
        foreach ($cc as $recipient) {
        }

        $message->setBody($body);

        return $this->mailer->send($message);
    }
    
    public function sendHtml($from, $to, $body)
    {
        $message = new Message();
    
        $message->setSender(new Address($from));
        $message->addRecipient($to);
    
        $message->setBody($body);
    
        return $this->mailer->send($message);
    }
}
