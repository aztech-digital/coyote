<?php

namespace Aztech\Coyote;

use Aztech\Coyote\Sms\Provider;
use Aztech\Coyote\Sms\Provider\NullProvider;

class SmsService
{

    private $provider;

    public function __construct(Provider $provider = null)
    {
        $this->provider = $provider ?: new NullProvider();
    }

    public function getProvider()
    {
        return $this->provider;
    }
}
