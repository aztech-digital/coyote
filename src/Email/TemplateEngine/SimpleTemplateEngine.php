<?php

namespace Aztech\Coyote\Email\TemplateEngine;

use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\TemplateEngine;

/**
 * Simple template engine that replaces variables using a  "{{ variable }}" syntax.
 *
 * @author thibaud
 */
class SimpleTemplateEngine implements TemplateEngine
{
    public function render(Message $message)
    {
        $variables = $message->getVariables();
        $content = $message->getBody();

        foreach ($variables as $name => $value) {
            $content = preg_replace('/{{\s*' . $name . '\s*}}/mi', $value, $content);
        }

        return $content;
    }
}
