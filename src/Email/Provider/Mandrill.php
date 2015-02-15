<?php

namespace Aztech\Coyote\Email\Provider;

use Aztech\Coyote\Email\Address;
use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\Provider;
use Aztech\Coyote\Email\RecipientStatusCollection;
use Aztech\Coyote\Email\RemoteTemplateMessage;

class Mandrill implements Provider
{

    use ProviderTrait;

    private $mandrill;

    private $defaultFrom;

    public function __construct(\Mandrill $mandrill, $defaultFrom)
    {
        $this->mandrill = $mandrill;
        $this->defaultFrom = new Address($defaultFrom);
    }

    public function sendMessage(Message $message)
    {
        throw new \RuntimeException('Non templated messages not implemented.');
    }

    public function sendRemoteTemplateMessage(RemoteTemplateMessage $message)
    {
        $data = [
            'to'   => $this->mapRecipients($message)
        ];

        $messages = new \Mandrill_Messages($this->mandrill);
        $status = new RecipientStatusCollection();

        $variables = $this->mapTemplateVariables($message);
        $response = $messages->sendTemplate($message->getBody(), $variables, $data);

        $this->addResponseToStatus($status, $response);

        return $status;
    }

    public function addResponseToStatus(RecipientStatusCollection $status, array $response)
    {
        foreach ($response as $recipientStatus) {
            if (! $recipientStatus['status'] == 'sent') {
                $status->add($recipientStatus['email'], false, $recipientStatus['reject_reason']);
            } else {
                $status->add($recipientStatus['email'], true);
            }
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
