<?php

namespace Aztech\Coyote\Sms;

class PhoneNumber
{
    private $countryCode;

    private $number;

    public function __construct($countryCode, $number)
    {
        if (substr($countryCode, 0, 1) == '+') {
            $countryCode = substr($countryCode, 1);
        }

        $this->countryCode = $countryCode;
        $this->number = $number;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getFullNumber()
    {
        return '+' . $this->countryCode . $this->number;
    }
}
