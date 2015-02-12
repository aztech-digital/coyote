<?php

namespace Aztech\Coyote\Email\Provider;

use Aztech\Coyote\Email\Address;
use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\Provider;
use Aztech\Coyote\Email\RemoteTemplateMessage;

class Mandrill implements Provider
{

    private $mandrill;

    private $defaultFrom;

    public function __construct(\Mandrill $mandrill, $defaultFrom)
    {
        $this->mandrill = $mandrill;
        $this->defaultFrom = new Address($defaultFrom);
    }

    public function send(Message $message)
    {
        $data = [
            'to'   => $this->mapRecipients($message)
        ];

        $messages = new \Mandrill_Messages($this->mandrill);

        if ($message instanceof RemoteTemplateMessage) {
            $messages->sendTemplate($message->getBody(), $this->mapTemplateVariables($message), $data);

            if ($data['status'] !== 'sent') {
                throw new \RuntimeException('Send failed: ' . $data['reject_reason']);
            }
        } else {
            throw new \RuntimeException('Non templated messages not implemented.');
        }
    }

    private function mapRecipients(Message $message)
    {
        $recipients = [];

        foreach ($message->getRecipients() as $recipient) {
            $recipients[] = [
                'email' => $recipient->getAddress(),
                'name'  => $recipient->getDisplayName(),
                'type'  => 'to'
            ];
        }

        return $recipients;
    }

    private function mapTemplateVariables(RemoteTemplateMessage $message)
    {
        $templateVariables = [];

        foreach ($message->getVariables() as $variable => $value) {
            $templateVariables[] = [
            'name' => $variable,
            'content' => $value
            ];
        }

        return $templateVariables;
    }
}
