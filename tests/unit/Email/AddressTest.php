<?php

namespace Aztech\Coyote\Tests\Email;

use Aztech\Coyote\Email\Address;
class AddressTest extends \PHPUnit_Framework_TestCase
{
    public function getInvalidAddresses()
    {
        return [
           [ "" ],
	       [ "notanemail" ],
	       [ "nodomainpart@" ],
	       [ "@noaddresspart.com"]
        ];
    }
    
    /**
     * 
     * @dataProvider getInvalidAddresses
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidEmailAddressesThrowAnException($address)
    {
        new Address($address);
    }
    
    public function testGetAddressReturnsAddressPart()
    {
        $address = new Address("test@domain.com", "Test");
        
        $this->assertEquals("test@domain.com", $address->getAddress());
    }
    
    public function testGetDisplayNameReturnsGivenDisplayName()
    {
        $address = new Address("test@domain.com", "Display name");
        
        $this->assertEquals("Display name", $address->getDisplayName());
    }
    
    public function testGetDisplayNameReturnsAddressWithoutDomainWhenDisplayNameNotGiven()
    {
        $address = new Address("test@domain.com");
        
        $this->assertEquals("test", $address->getDisplayName());
    }
    
    public function testSetDisplayNameUpdatesDisplayName()
    {
        $address = new Address("test@domain.com", "Display name");
        $address->setDisplayName("New name");
        
        $this->assertEquals("New name", $address->getDisplayName());
    }
    
    public function testGetAsNameAddressReturnsFullDisplayWhenDisplayNameIsSet()
    {
        $address = new Address("test@domain.com", "Display name");
        
        $this->assertEquals("Display name <test@domain.com>", $address->getAsNameAddress());
    }
    
    public function testGetAsNameAddressReturnsFullDisplayWhenDisplayNameIsNotSet()
    {
        $address = new Address("test@domain.com");
    
        $this->assertEquals("test@domain.com", $address->getAsNameAddress());
    }
    
    public function testToStringReturnsAddressSpec()
    {
        $address = new Address("test@domain.com", "Display name");
        
        $this->assertEquals("test@domain.com", (string) $address);
    }
}