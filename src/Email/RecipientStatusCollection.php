<?php

namespace Aztech\Coyote\Email;

class RecipientStatusCollection
{

    private $count = 0;

    private $successes = [];

    private $errors = [];

    public function addMessageStatus(Message $message, $success, $errorMessage = null, \Exception $exception = null)
    {
        foreach ($message->getRecipients() as $recipient) {
            $this->add($recipient, $success, $errorMessage, $exception);
        }

        foreach ($message->getCcRecipients() as $recipient) {
            $this->add($recipient, $success, $errorMessage, $exception);
        }

        foreach ($message->getBccRecipients() as $recipient) {
            $this->add($recipient, $success, $errorMessage, $exception);
        }
    }

    public function add($recipient, $success, $errorMessage = null, \Exception $exception = null)
    {
        if (! ($recipient instanceof Address)) {
            $recipient = new Address($recipient);
        }

        $this->addStatus(new RecipientStatus($recipient, $success, $errorMessage, $exception));
    }

    public function addStatus(RecipientStatus $status)
    {
        if (! $status->isSuccess()) {
            $this->errors[$this->count++] = $status;
        } else {
            $this->successes[$this->count++] = $status;
        }
    }

    public function isSuccess()
    {
        return empty($this->errors);
    }

    public function getStatuses()
    {
        return array_merge($this->statuses, $this->errors);
    }

    public function getSuccesses()
    {
        return $this->successes;
    }

    public function getFailures()
    {
        return $this->failures;
    }
}
