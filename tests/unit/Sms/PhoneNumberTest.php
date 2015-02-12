<?php

namespace Aztech\Coyote\Tests;

use Aztech\Coyote\Sms\PhoneNumber;

class PhoneNumberTest extends \PHPUnit_Framework_TestCase
{

    public function getTestNumbers()
    {
        return [
            [ '33', '61616161', '+3361616161' ],
            [ '+33', '61616161', '+3361616161' ]
        ];
    }

    /**
     * @dataProvider getTestNumbers
     */
    public function testGetFullNumber($countryCode, $number, $expected)
    {
        $number = new PhoneNumber($countryCode, $number);

        $this->assertEquals($expected, $number->getFullNumber());
    }
}
