<?php

namespace Aztech\Coyote\Sms;

interface ProviderFactory
{
    public function buildProvider(array $configuration);
}
