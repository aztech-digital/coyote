<?php

namespace Aztech\Coyote\Email;

interface ProviderFactory
{
    /**
     *
     * @param array $configuration
     * @return Provider
     */
    public function buildProvider(array $configuration);
}
