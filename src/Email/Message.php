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
    private $subject = '';

    /**
     *
     * @var Address
     */
    private $sender = null;

    /**
     *
     * @var Address[]
     */
    private $recipients = null;

    /**
     *
     * @var Address[]
     */
    private $ccRecipients = null;


    /**
     *
     * @var mixed[]
     */
    private $variables = array();


    public function __construct()
    {
        $this->recipients = new AddressCollection();
        $this->ccRecipients = new AddressCollection();
    }

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
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the mail subject.
     *
     * @param string $title
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
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
     * @return boolean
     */
    public function isHtmlMessage()
    {
        return $this->isHtml;
    }

    /**unknown
     * Returns all set recipients.
     * @return AddressCollection
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Returns all set carbon-copy recipients.
     * @return AddressCollection
     */
    public function getCcRecipients()
    {
        return $this->ccRecipients;
    }

    /**
     * Returns all the set variables for the message's body template.
     *
     * @return mixed[]
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * Sets a variable used to render the message's body if it contains template syntax.
     *
     * @param string $name
     * @param mixed $value
     */
    public function setVariable($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /**
     * Sets the variables used to render the message's body if it contains template syntax.
     * Replaces all the currently set variables.
     *
     * @param array $values
     */
    public function setVariables(array $values)
    {
        $this->variables = $values;
    }

    public function acceptProvider(Provider $provider)
    {
        return $provider->sendMessage($this);
    }
}
