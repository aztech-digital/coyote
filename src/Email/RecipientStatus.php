<?php

namespace Aztech\Coyote\Email;

class RecipientStatus
{
    /**
     * @var Address
     */
    private $recipient;

    /**
     * @var bool
     */
    private $success;

    /**
     *
     * @var string
     */
    private $errorMessage = '';

    /**
     * @var \Exception|null
     */
    private $exception;

    public function __construct(Address $recipient, $success, $errorMessage = null, \Exception $exception = null)
    {
        $this->recipient = $recipient;
        $this->success = (bool) $success;
        $this->errorMessage = (string) ($errorMessage ?: '<null error message>');
        $this->exception = $exception;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function isSuccess()
    {
        return ($this->success === true);
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function hasException()
    {
        return ($this->exception !== null);
    }

    public function getException()
    {
        if (! $this->hasException()) {
            throw new \BadMethodCallException('No exception data available.');
        }

        return $this->exception;
    }
}