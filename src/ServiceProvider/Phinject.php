<?php

namespace Aztech\Coyote\ServiceProvider;

use Aztech\Coyote\EmailService;
use Aztech\Coyote\SmsService;
use Aztech\Phinject\Activator;
use Aztech\Phinject\ConfigurationAware;
use Aztech\Phinject\Container;
use Aztech\Phinject\UnbuildableServiceException;
use Aztech\Phinject\Util\ArrayResolver;
use Psr\Log\LoggerAwareInterface;

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
                $container,
                $providerName,
                $serviceConfig->resolveArray($providerName, [])
            );
        }

        throw new UnbuildableServiceException('Unsupported provider type: ' . $providerType);
    }

    private function buildEmailService(Container $container, $providerName, ArrayResolver $providerConfig)
    {
        if (! array_key_exists($providerName, $this->emailFactories)) {
            throw new UnbuildableServiceException('Unsupported provider: ' . $providerName);
        }

        $factory = new $this->emailFactories[$providerName]();
        $provider = $factory->buildProvider($this->resolveConfigValues($container, $providerConfig->extract()));

        if ($provider instanceof LoggerAwareInterface && $logger = $providerConfig->resolve('logger', false)) {
            $provider->setLogger($container->resolve($logger));
        }

        return new EmailService($provider);
    }

    private function resolveConfigValues($container, array $config)
    {
        $resolved = [];

        foreach ($config as $name => $value) {
            $resolved[$name] = $container->resolve($value);
        }

        return $resolved;
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
