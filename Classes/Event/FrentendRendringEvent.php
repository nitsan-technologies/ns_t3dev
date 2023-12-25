<?php

namespace NITSAN\NsT3dev\Event;

use Psr\EventDispatcher\StoppableEventInterface;

class FrentendRendringEvent implements StoppableEventInterface
{
    
    public function isPropagationStopped(): bool
    {
        return false;
    }
}

?>