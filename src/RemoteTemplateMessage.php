<?php

namespace Aztech\Coyote;

class RemoteTemplateMessage extends Message
{

    private $variables = array();

    public function setVariable($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function setVariables(array $values)
    {
        $this->variables = $values;
    }
    
    public function getVariables()
    {
        return $this->variables;
    }
}
