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
            $content = str_replace('{{' . $name . '}}', $value, $content);
        }

        return $content;
    }
}