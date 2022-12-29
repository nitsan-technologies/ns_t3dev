<?php
namespace NITSAN\NsT3dev\Task;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility as transalte;

/**
 * Class NsT3devField
 */
class NsT3devField implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface
{

    /**
     * Create additional fields
     * @param array $taskInfo
     * @param \NITSAN\NsThemeNedo\Task\Task $task
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject
     * @return array
     */
    public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject)
    {
        if (empty($taskInfo['csvpath'])) {
            if ($parentObject->getCurrentAction() == 'add') {
                $taskInfo['csvpath'] = '';
            } else {
                $taskInfo['csvpath'] = $task->csvpath;
            }
        }

        if (empty($taskInfo['pid'])) {
            if ($parentObject->getCurrentAction() == 'add') {
                $taskInfo['pid'] = '';
            } else {
                $taskInfo['pid'] = (int)$task->pid;
            }
        }

        // Inputfields
        $additionalFields = [

            'task_pid' => [
                'code' => '<input type="number"class="form-control" require="required" name="tx_scheduler[pid]" value="' . (int)$taskInfo['pid'] . '"/>',
                'label' => transalte::translate('scheduler.pid', 'ns_t3dev'),
            ],
            'task_csvpath' => [
                'code' => '<input type="text" class="form-control" name="tx_scheduler[csvpath]" value="' . $taskInfo['csvpath'] . '"/>',
                'label' => transalte::translate('scheduler.csvpath', 'ns_t3dev'),
            ],
            
        ];

        return $additionalFields;
    }

    /**
     * Validates the input value(s)
     * @param array $submittedData
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject
     * @return bool
     */
    public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject)
    {
        // Validation Codes Goes Here
        return true;
    }

    /**
     * Saves the input value
     * @param array $submittedData
     * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task
     */
    public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task)
    {
        $task->csvpath = trim($submittedData['csvpath']);
        $task->pid = trim((int)$submittedData['pid']);
    }
}
