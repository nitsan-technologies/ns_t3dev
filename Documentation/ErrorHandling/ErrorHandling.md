# Error Handling

* You can store your custom error messages in the log files and the database.
* Add the below code in your classes to generate the log entries in the log file.
```sh
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Log\LogManager;


class MyController extends ActionController implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct()
    {
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);

        $this->logger->warning($logMessage);
    }
}

```

* Store the generated log in the database. You can also store the log data in your custom table.
```sh
$connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_log');

        if (!$connection->isConnected()) {
            return;
        }
        $workspace = 0;
        $userId = 0;
        if(isset($GLOBALS['BE_USER']->user)){
            $backendUser = $GLOBALS['BE_USER']->user;
            if (isset($backendUser['uid'])) {
                $userId = $backendUser['uid'];
            }

        }

        $this->productAreaRepository->generateErrorLog($userId,$logMessage,$workspace);
```
* Use the Insert query in the Repository
```sh
$tableConnectionCategoryMM = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_log');


        $logdata[$userId] = [
            'userid' => $userId,
            'type' => SystemLogType::ERROR,
            'channel' => SystemLogType::toChannel(SystemLogType::ERROR),
            'action' => SystemLogGenericAction::UNDEFINED,
            'error' => SystemLogErrorClassification::SYSTEM_ERROR,
            'level' => SystemLogType::toLevel(SystemLogType::ERROR),
            'details_nr' => 0,
            'details' => str_replace('%', '%%', $logMessage),
            'IP' => (string)GeneralUtility::getIndpEnv('REMOTE_ADDR'),
            'tstamp' => $GLOBALS['EXEC_TIME'],
            'workspace' => $workspace,
        ];

        if (!empty($logdata)) {
            $tableConnectionCategoryMM->bulkInsert(
                'sys_log',
                array_values($logdata),
                ['userid', 'type', 'channel', 'action', 'error', 'level', 'details_nr', 'details', 'IP', 'tstamp', 'workspace']
            );
        }
```

