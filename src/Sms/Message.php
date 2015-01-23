<?php

namespace Aztech\Coyote\Sms;

use Aztech\Coyote\PhoneNumber;

/**
 * Class for storing phone numbers, and formatting them using international notation;
 *
 * @author thibaud
 */
class Message
{
    /**
     *
     * @var string
     */
    private $body;

    /**
     *
     * @var PhoneNumber
     */
    private $sender;

    /**
     *
     * @var PhoneNumber[]
     */
    private $recipients = [];

    /**
     *
     * @param PhoneNumber $recipient
     * @param PhoneNumber $sender
     */
    public function __construct($body, PhoneNumber $recipient = null, PhoneNumber $sender = null)
    {
        if ($recipient !== null) {
            $this->recipients[] = $recipient;
        }

        $this->body = $body;
        $this->sender = $sender;
    }

    public function getBody()
    {
        return $this->body;
    }

    /**
     *
     * @return PhoneNumber|null
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     *
     * @param PhoneNumber $recipient
     * @return void
     */
    public function addRecipient(PhoneNumber $recipient)
    {
        $this->recipients[] = $recipient;
    }

    /**
     *
     * @return PhoneNumber[]
     */
    public function getRecipients()
    {
        return $this->recipients;
    }
}
