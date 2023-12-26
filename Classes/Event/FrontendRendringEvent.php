<?php

namespace NITSAN\NsT3dev\Event;

use Psr\EventDispatcher\StoppableEventInterface;

class FrontendRendringEvent implements StoppableEventInterface
{
    public function isPropagationStopped(): bool
    {
        return false;
    }
}

?>