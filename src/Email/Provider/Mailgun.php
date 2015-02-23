<?php

namespace Aztech\Coyote\Email\Provider;

use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\Provider;
use Aztech\Coyote\Email\RecipientStatusCollection;
use Aztech\Coyote\Email\RemoteTemplateMessage;
use Mailgun\Mailgun as MailgunApi;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Aztech\Coyote\Email\AddressCollection;
use Aztech\Coyote\Email\TemplateEngine\SimpleTemplateEngine;

class Mailgun implements Provider, LoggerAwareInterface
{

    use ProviderTrait;

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
        $this->templateEngine = new SimpleTemplateEngine();
    }

    /**
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * (non-PHPdoc)
     * @see \Aztech\Coyote\Email\Provider::sendMessage()
     */
    public function sendMessage(Message $message)
    {
        $postData = $this->convertMessage($message);

        $this->logger->info(sprintf('Forwarding mail "%s" to "%s"', $postData['subject'], $postData['to']));

        $status = new RecipientStatusCollection();
        $result = $this->mailgun->sendMessage($this->domain, $postData);

        if ($result->http_response_code != 200) {
            $status->addMessageStatus($message, false, "Send failed.");
        } else {
            $status->addMessageStatus($message, true);
        }

        return $status;
    }

    public function sendRemoteTemplateMessage(RemoteTemplateMessage $message)
    {
        throw new \BadMethodCallException('Mailgun does not provide remote templates.');
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
        $data['subject'] = $message->getSubject();
        $data['html'] = $this->renderMessage($message);

        return $data;
    }

    private function convertAddresses(AddressCollection $addresses)
    {
        return implode(',', array_map(function ($address) {
            return $address->getAsNameAddress();
        }, $addresses->getAddresses()));
    }
}
