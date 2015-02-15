<?php

namespace Aztech\Coyote\Email;

class TemplateMessage extends Message
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

    public function getBody()
    {
        return $this->renderTemplate(parent::getBody());
    }

    private function renderTemplate($content)
    {
        foreach ($this->variables as $name => $value) {
            $content = preg_replace('/{{\s*' . $name . '\s*}}/mi', $value, $content);
        }

        return $content;
    }
}
