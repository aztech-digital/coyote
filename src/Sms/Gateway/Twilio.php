<?php

namespace Aztech\Coyote\Sms\Gateway;

use Aztech\Coyote\Sms\MessageGateway;
use Aztech\Coyote\Sms\Message;
use Aztech\Coyote\PhoneNumber;

class Twilio implements MessageGateway
{

    private $twilio;

    private $defaultSender;

    public function __construct(\Services_Twilio $service, $defaultSenderCountry, $defaultSenderNumber)
    {
        $this->twilio = $service;
        $this->defaultSender = new PhoneNumber($defaultSenderCountry, $defaultSenderNumber);
    }

    /*
     * (non-PHPdoc) @see \Aztech\Coyote\Sms\MessageGateway::send()
     */
    public function send(Message $message)
    {
        if (empty($message->getRecipients()) {
            throw new \InvalidArgumentException('Message has no recipients');
        }

        $data = $this->mapMessage($message);

        foreach ($data as $item) {
            try {
                $this->twilio->account->messages->create($item);
            }
            catch (\Services_Twilio_RestException $exception) {
                throw new \RuntimeException($exception->getMessage(), 0, $exception);
            }
        }
    }

    private function mapMessage(Message $message)
    {
        $sender = $message->getSender() ?: $this->defaultSender;

        $data = [];
        $commonData = [
            'From' => $sender->getFullNumber(),
            'Body' => $message->getBody()
        ];

        foreach ($message->getRecipients() as $recipient) {
            $data[] = array_merge($commonData, [
                'To' => $recipient->getFullNumber()
            ]);
        }

        return $data;
    }
}
