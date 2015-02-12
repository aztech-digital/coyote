<?php

namespace Aztech\Coyote\Email;

/**
 * Email message class.
 * @author thibaud
 *
 */
class Message
{

    /**
     *
     * @var string
     */
    private $body = '';

    /**
     *
     * @var bool
     */
    private $isHtml = false;

    /**
     *
     * @var string
     */
    private $title = '';

    /**
     *
     * @var Address
     */
    private $sender = null;

    /**
     *
     * @var Address[]
     */
    private $recipients = array();

    /**
     * Returns the sender address or null if it is not set.
     * @return Address
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Sets the sender address.
     * @param Address $sender
     */
    public function setSender(Address $sender)
    {
        $this->sender = $sender;
    }

    /**
     * Gets the mail body.
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Sets the mail body.
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
        $this->isHtml = false;
    }

    /**
     * Gets the mail subject
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the mail subject.
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Sets the mail body in HTML format.
     * @param string $body
     */
    public function setHtmlBody($body)
    {
        $this->body = $body;
        $this->isHtml = true;
    }

    /**
     * Sets the recipient addresses. This method replaces any previously added recipient.
     * @param Address[] $recipients
     * @throws \InvalidArgumentException when $recipients contains elements that are not instances of Mail_Address.
     */
    public function setRecipients(array $recipients = array())
    {
        foreach ($recipients as $recipient) {
            if (! $recipient instanceof Address) {
                throw new \InvalidArgumentException('$recipients can only contain instances of Mail_Address.');
            }
        }

        $this->recipients = $recipients;
    }

    /**
     * Adds a recipient to the mail.
     * @param Address $recipient
     */
    public function addRecipient(Address $recipient)
    {
        $this->recipients[] = $recipient;
    }

    /**
     * Returns all set recipients.
     * @return Address[]
     */
    public function getRecipients()
    {
        return $this->recipients;
    }
}
