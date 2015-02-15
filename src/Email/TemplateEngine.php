<?php

namespace Aztech\Coyote\Email;

interface TemplateEngine
{
    public function render(Message $message);
}
