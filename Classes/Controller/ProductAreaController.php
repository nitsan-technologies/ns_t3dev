<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Controller;

use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use NITSAN\NsT3dev\Event\FrontendRendringEvent;

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
class ProductAreaController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

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

    public function __construct() {
        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
    }


    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $this->eventDispatcher->dispatch(
            new FrontendRendringEvent()
        );
        $productAreas = $this->productAreaRepository->findAll();
        $currentPage = $this->request->hasArgument('currentPage')
            ? (int)$this->request->getArgument('currentPage')
            : 1;
        $itemsPerPage = $this->settings['itemsPerPage'] ? $this->settings['itemsPerPage'] : 5;
        $maximumLinks = 15;
        $paginator = new QueryResultPaginator($productAreas,$currentPage,intval($itemsPerPage));
        $pagination = new SimplePagination($paginator,$maximumLinks);
        $this->view->assign(
            'pagination',
            [
                'pagination' => $pagination,
                'paginator' => $paginator,
            ]
        );
        $this->view->assign('productAreas', $productAreas);
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
        $this->persistenceManager->persistAll();
        if($_FILES['tx_nst3dev_listing']){
            $newFile = $this->getUploadedFileData($_FILES['tx_nst3dev_listing']['tmp_name']['image'], $_FILES['tx_nst3dev_listing']['name']['image']);
            $fileData = $newFile->getProperties();
            if ($fileData) {
                $this->productAreaRepository->updateSysFileReferenceRecord(
                    (int)$fileData['uid'],
                    (int)$newProductArea->getUid(),
                    (int)$newProductArea->getPid(),
                    'tx_nst3dev_domain_model_productarea',
                    'image'
                );
                $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
                $fileObjects = $fileRepository->findByRelation(
                    'tx_nst3dev_domain_model_productarea',
                    'image',
                    $newProductArea->getUid()
                );
            }
        }

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
        if($_FILES['tx_nst3dev_listing']['tmp_name']['image']){
            $newFile = $this->getUploadedFileData($_FILES['tx_nst3dev_listing']['tmp_name']['image'], $_FILES['tx_nst3dev_listing']['name']['image']);
            $fileData = $newFile->getProperties();
            if ($fileData) {
                $this->productAreaRepository->updateSysFileReferenceRecord(
                    (int)$fileData['uid'],
                    (int)$productArea->getUid(),
                    (int)$productArea->getPid(),
                    'tx_nst3dev_domain_model_productarea',
                    'image'
                );
                $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
                $fileObjects = $fileRepository->findByRelation(
                    'tx_nst3dev_domain_model_productarea',
                    'image',
                    $productArea->getUid()
                );
            }
        }
        $this->productAreaRepository->update($productArea);
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
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
     * action validation
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function validationAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    public function getUploadedFileData(string $tmpName, string $fileName): File
    {
        $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
        $storage = $resourceFactory->getDefaultStorage();
        $folderPath = $storage->getRootLevelFolder();
        $newFile = $storage->addFile($tmpName, $folderPath,$fileName);
        return $newFile;

    }
}
