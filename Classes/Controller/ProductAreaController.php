<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Controller;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\SysLog\Action as SystemLogGenericAction;
use TYPO3\CMS\Core\SysLog\Error as SystemLogErrorClassification;
use TYPO3\CMS\Core\SysLog\Type as SystemLogType;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "T3 Dev" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Nilesh Malankiya <nilesh@nitsantech.com>, NITSAN Technologies
 */

/**
 * ProductAreaController
 */
class ProductAreaController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController implements LoggerAwareInterface
{

    use LoggerAwareTrait;

    public function __construct() {
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
    }

    /**
     * productAreaRepository
     *
     * @var \NITSAN\NsT3dev\Domain\Repository\ProductAreaRepository
     */
    protected $productAreaRepository = null;

    /**
     * @param \NITSAN\NsT3dev\Domain\Repository\ProductAreaRepository $productAreaRepository
     */
    public function injectProductAreaRepository(\NITSAN\NsT3dev\Domain\Repository\ProductAreaRepository $productAreaRepository)
    {
        $this->productAreaRepository = $productAreaRepository;
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $productAreas = $this->productAreaRepository->findAll();

        if(count($productAreas) > 0){
            $this->view->assign('productAreas', $productAreas);
        } else {
            $logTitle = 'Data Error';
            $logMessage = 'Something went awry, No Data Found!';
            $this->logger->warning($logMessage);
            try {
                // Write error message to sys_log table
                $this->writeErrorLog($logMessage);
            } catch (\Exception $exception) {
            }
        }
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \NITSAN\NsT3dev\Domain\Model\ProductArea $productArea
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\NITSAN\NsT3dev\Domain\Model\ProductArea $productArea): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('productArea', $productArea);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \NITSAN\NsT3dev\Domain\Model\ProductArea $newProductArea
     */
    public function createAction(\NITSAN\NsT3dev\Domain\Model\ProductArea $newProductArea)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->productAreaRepository->add($newProductArea);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \NITSAN\NsT3dev\Domain\Model\ProductArea $productArea
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("productArea")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\NITSAN\NsT3dev\Domain\Model\ProductArea $productArea): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('productArea', $productArea);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \NITSAN\NsT3dev\Domain\Model\ProductArea $productArea
     */
    public function updateAction(\NITSAN\NsT3dev\Domain\Model\ProductArea $productArea)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->productAreaRepository->update($productArea);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \NITSAN\NsT3dev\Domain\Model\ProductArea $productArea
     */
    public function deleteAction(\NITSAN\NsT3dev\Domain\Model\ProductArea $productArea)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->productAreaRepository->remove($productArea);
        $this->redirect('list');
    }

    /**
     * Writes an error in the sys_log table
     *
     * @param string $logMessage Default text that follows the message (in english!).
     */
    protected function writeErrorLog($logMessage)
    {
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

        $connection->insert(
            'sys_log',
            [
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
            ]
        );
    }
}
