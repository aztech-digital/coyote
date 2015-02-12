<?php

namespace Aztech\Coyote\Email;

/**
 * Email address class providing formatting methods compliant to RFC2822-3.4 specifications.
* @author thibaud
*
*/
class Address
{
    const DOMAIN_SEPARATOR = '@';

    const NAMEADDR_FORMAT = '%s <%s>';

    private $address = '';

    private $displayName = '';

    public function __construct($address, $displayName = '')
    {
        if (trim($address) == '') {
            throw new \InvalidArgumentException('$address cannot be an empty string.');
        }

        $this->address = trim($address);
        $this->displayName = trim($displayName);
    }

    /**
     * Returns the email address (addr-spec).
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Returns the address part of the email address without the associated domain.
     * @return string
     */
    private function getAddressWithoutDomain()
    {
        return strstr($this->address, self::DOMAIN_SEPARATOR, true);
    }

    /**
     * Returns the name associated with this address (display-name).
     * @return string
     */
    public function getDisplayName()
    {
        if (!empty($this->displayName)) {
            return $this->displayName;
        }

        return $this->getAddressWithoutDomain();
    }

    /**
     * Sets the display name for the address.
     * @param string $name
     */
    public function setDisplayName($name)
    {
        $this->displayName = trim($name);
    }

    /**
     * Returns the current address formatted as a mailbox address (name-addr).
     * @return string
     */
    public function getAsNameAddress()
    {
        $displayName = $this->getDisplayName();

        if ($this->getAddressWithoutDomain() == $displayName) {
            return $this->address;
        }

        return sprintf(self::NAMEADDR_FORMAT, $this->getDisplayName(), $this->address);
    }

    /**
     * Returns the addr-spec part of the address only for compatibility with string based methods.
     * @return string
     */
    public function __toString()
    {
        return $this->address;
    }
}
