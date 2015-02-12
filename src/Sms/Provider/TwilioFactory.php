<?php

namespace Aztech\Coyote\Sms\Provider;

use Aztech\Coyote\Sms\ProviderFactory;

class TwilioFactory implements ProviderFactory
{

    /**
     * (non-PHPdoc)
     * @see \Aztech\Coyote\Sms\ProviderFactory::buildProvider()
     */
    public function buildProvider(array $configuration)
    {
        $defaultSenderCountry = $configuration['sender']['country'];
        $defaultSenderNumber = $configuration['sender']['number'];

        $sid = $configuration['key'];
        $token = $configuration['token'];

        $service = new \Services_Twilio($sid, $token);

        return new Twilio($service, $defaultSenderCountry, $defaultSenderNumber);
    }
}
