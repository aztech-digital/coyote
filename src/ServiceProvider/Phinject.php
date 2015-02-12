<?php

namespace Aztech\Coyote\ServiceProvider;

use Aztech\Coyote\EmailService;
use Aztech\Coyote\SmsService;
use Aztech\Phinject\Activator;
use Aztech\Phinject\ConfigurationAware;
use Aztech\Phinject\Container;
use Aztech\Phinject\UnbuildableServiceException;
use Aztech\Phinject\Util\ArrayResolver;

class Phinject implements Activator, ConfigurationAware
{
    private $key;

    private $emailFactories;

    private $smsFactories;

    public function __construct()
    {
        $this->emailFactories = [
            'mailgun' => 'Aztech\Coyote\Email\Provider\MailgunFactory'
        ];

        $this->smsFactories = [
            'twilio' => 'Aztech\Coyote\Sms\Provider\TwilioFactory'
        ];
    }

    public function setConfiguration(ArrayResolver $configurationNode)
    {
        $this->key = $configurationNode->resolveStrict('key');
    }

    public function createInstance(Container $container, ArrayResolver $serviceConfig, $serviceName)
    {
        $coyoteConfig = $serviceConfig->resolveArray($this->key, []);

        $providerType = $coyoteConfig->resolveStrict('type');
        $providerName = $coyoteConfig->resolveStrict('provider');

        if ($providerType === 'sms') {
            return $this->buildSmsService(
                $providerName,
                $serviceConfig->resolveArray($providerName, [])
            );
        } elseif ($providerType === 'email') {
            return $this->buildEmailService(
                $providerName,
                $serviceConfig->resolveArray($providerName, [])
            );
        }

        throw new UnbuildableServiceException('Unsupported provider type: ' . $providerType);
    }

    private function buildEmailService($providerName, ArrayResolver $providerConfig)
    {
        if (! array_key_exists($providerName, $this->emailFactories)) {
            throw new UnbuildableServiceException('Unsupported provider: ' . $providerName);
        }

        $factory = new $this->emailFactories[$providerName]();
        $provider = $factory->buildProvider($providerConfig->extract());

        return new EmailService($provider);
    }

    private function buildSmsService($providerName, ArrayResolver $providerConfig)
    {
        if (! array_key_exists($providerName, $this->smsFactories)) {
            throw new UnbuildableServiceException('Unsupported provider: ' . $providerName);
        }

        $factory = new $this->smsFactories[$providerName]();
        $provider = $factory->buildProvider($providerConfig->extract());

        return new SmsService($provider);
    }
}
