<?php

namespace NITSAN\NsT3dev\Task;

/**
 * Class Task
 */
class Task extends \TYPO3\CMS\Scheduler\Task\AbstractTask
{

    /**
     * Function executed from the Scheduler.
     *
     * @return bool
     */
    public function execute()
    {
        // Business Logic Goes Here
        return true;
    }
}
