<?php

namespace Aztech\Coyote\Tests\Email;

use Aztech\Coyote\Email\AddressCollection;
use Aztech\Coyote\Email\Address;

class AddressCollectionTest extends \PHPUnit_Framework_TestCase
{
    
    public function testConstructWithAddresses()
    {
        $address = new Address("test@domain.com");
        $addresses = new AddressCollection([ $address ]);
        
        $this->assertCount(1, $addresses);
        $this->assertContains($address, $addresses);
    }
    
    public function testConstructWithStringAddresses()
    {
        $address = "test@domain.com";
        $addresses = new AddressCollection([ $address ]);
    
        $this->assertCount(1, $addresses);
        $this->assertContains($address, $addresses);
    }
    
    public function testAddAddress()
    {
        $address = new Address("test@domain.com");
        $addresses = new AddressCollection();
        
        $addresses->addAddress($address);
        
        $this->assertCount(1, $addresses);
        $this->assertContains($address, $addresses);
    }
    
    public function testAddAddresses()
    {
        $address = new Address("test@domain.com");
        $addresses = new AddressCollection();
    
        $addresses->addAddresses([ $address ]);
    
        $this->assertCount(1, $addresses);
        $this->assertContains($address, $addresses);
    }
    
    public function testAddressesWithStringValues()
    {
        $address = "test@domain.com";
        $addresses = new AddressCollection();
        
        $addresses->addAddresses([ $address ]);
        
        $this->assertCount(1, $addresses);
        $this->assertContains($address, $addresses);
    }
    
    public function testGetAddresses()
    {
        $address = new Address("test@domain.com");
        $addresses = new AddressCollection();
        
        $addresses->addAddresses([ $address ]);
        $addresses = $addresses->getAddresses();
        
        $this->assertCount(1, $addresses);
        $this->assertContains($address, $addresses);
    }
    
    public function testCountReturnsActualCollectionCount()
    {
        $collection = new AddressCollection();
        
        $this->assertEquals(0, count($collection));
        
        for ($i = 1; $i <= 10; $i++) {
            $collection->addAddress(new Address("test" . $i . "@domain.com"));
            $this->assertEquals($i, count($collection));
        }
    }
    
    public function testIteration()
    {
        $collection = new AddressCollection();
        
        for ($i = 1; $i <= 10; $i++) {
            $collection->addAddress(new Address("test" . $i . "@domain.com"));
        }
        
        $i = 0;
        
        foreach ($collection as $key=> $address) {
            $this->assertEquals($i, $key);
            $this->assertEquals("test" . ++$i . "@domain.com", $address->getAddress());
        }
    }
}