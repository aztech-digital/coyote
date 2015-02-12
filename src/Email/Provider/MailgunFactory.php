<?php

namespace Aztech\Coyote\Email\Provider;

use Aztech\Coyote\Email\ProviderFactory;
use Mailgun\Mailgun as MailgunApi;

class MailgunFactory implements ProviderFactory
{

    /**
     * (non-PHPdoc)
     * @see \Aztech\Coyote\Email\ProviderFactory::buildProvider()
     */
    public function buildProvider(array $configuration)
    {
        $apiKey = $configuration['key'];
        $domain = $configuration['domain'];

        $useSsl = isset($configuration['ssl']) ? (bool) $configuration['ssl'] : true;

        $mailgunApi = new MailgunApi($apiKey, 'api.mailgun.net', 'v2', $useSsl);
        $provider = new Mailgun($mailgunApi, $domain);

        return $provider;
    }
}
