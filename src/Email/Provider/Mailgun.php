<?php

namespace Aztech\Coyote\Email\Provider;

use \Aztech\Coyote\Email\Message;
use \Aztech\Coyote\Email\Provider;
use Mailgun\Mailgun as MailgunApi;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Mailgun implements Provider, LoggerAwareInterface
{

    /**
     *
     * @var MailgunApi
     */
    private $mailgun;

    /**
     *
     * @var string
     */
    private $domain;

    /**
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     *
     * @param MailgunApi $mailgun
     * @param string $domain
     */
    public function __construct(MailgunApi $mailgun, $domain)
    {
        $this->mailgun = $mailgun;
        $this->domain = $domain;
        $this->logger = new NullLogger();
    }

    /**
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
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
        return implode(',', array_map(function ($address) {
            return $address->getAsNameAddress();
        }, $addresses));
    }
}
