<?php

namespace Aztech\Coyote\Email;

use Aztech\Coyote\CoyoteException;

class SendFailedException extends CoyoteException
{
    private $statusCollection;

    public function __construct(RecipientStatusCollection $collection)
    {
        parent::__construct('Send failed');

        $this->statusCollection = $collection;
    }

    public function getStatusCollection()
    {
        return $this->statusCollection;
    }
}