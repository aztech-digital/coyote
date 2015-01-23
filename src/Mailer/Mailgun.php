<?php

namespace Aztech\Coyote\Mailer;

use \Aztech\Coyote\Mailer;
use \Aztech\Coyote\Message;
use Psr\Log\NullLogger;

class Mailgun implements Mailer
{

    /**
     *
     * @var \Mailgun\Mailgun
     */
    private $mailgun;

    /**
     *
     * @var string
     */
    private $domain;

    /**
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(\Mailgun\Mailgun $mailgun, $domain)
    {
        $this->mailgun = $mailgun;
        $this->domain = $domain;
        $this->logger = new NullLogger();
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    public function send(Message $message)
    {
        $postData = $this->convertMessage($message);
        $this->logger->info(sprintf('Forwarding mail "%s" to "%s"', $postData['subject'], $postData['to']));

        $result = $this->mailgun->sendMessage($this->domain, $postData);

        if ($result->http_response_code != 200) {
            throw new \RuntimeException('Call to remote mailer failed.');
        }
    }

    /**
     *
     * @param Message $message
     * @return array
     */
    private function convertMessage(Message $message)
    {
        $data = array();

        $data['from'] = $message->getSender()->getAsNameAddress();
        $data['to'] = $this->convertAddresses($message->getRecipients());
        $data['subject'] = $message->getTitle();
        $data['html'] = $message->getBody();

        return $data;
    }

    private function convertAddresses(array $addresses)
    {
        return implode(',', array_map(function ($address)
        {
            return $address->getAsNameAddress();
        }, $addresses));
    }
}
