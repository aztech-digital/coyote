<?php

namespace Aztech\Coyote\Email;

/**
 * Type safe collection of email addresses
 * @author thibaud
 *
 */
class AddressCollection implements \Countable, \Iterator
{
    /**
     * 
     * @var Address[]
     */
    private $addresses = [];
    
    /**
     * Initialize a new collection with an optional list of addresses.
     * 
     * @param array $addresses
     */
    public function __construct(array $addresses = [])
    {
        $this->addAddresses($addresses);
    }
    
    /**
     * 
     * @param Address $address
     */
    public function addAddress(Address $address)
    {
        $this->addresses[] = $address;
    }
    
    public function addAddresses(array $addresses)
    {
        foreach ($addresses as $address) {
            if (! ($address instanceof Address)) {
                $address = new Address($address);
            }
            
            $this->addAddress($address);
        }
    }
    
    public function getAddresses()
    {
        return $this->addresses;
    }
    
    public function count()
    {
        return count($this->addresses);
    }
    
    public function current()
    {
        return current($this->addresses);
    }
    
    public function key()
    {
        return key($this->addresses);
    }
    
    public function next()
    {
        next($this->addresses);
    }
    
    public function rewind()
    {
        reset($this->addresses);
    }
    
    public function valid()
    {
        return (current($this->addresses) !== false);
    }
}