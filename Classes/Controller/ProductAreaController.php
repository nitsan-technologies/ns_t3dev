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
use Psr\Http\Message\ResponseInterface;
use NITSAN\NsT3dev\Domain\Repository\ProductAreaRepository;
use NITSAN\NsT3dev\Domain\Model\ProductArea;
use TYPO3\CMS\Core\Messaging\AbstractMessage;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;


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

class ProductAreaController extends ActionController
{
    /**
     * productAreaRepository
     *
     * @var ProductAreaRepository
     */
    protected $productAreaRepository;


    public function __construct(
        ProductAreaRepository $productAreaRepository
    )
    {
        $this->productAreaRepository = $productAreaRepository;
        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
    }

    /**
     * action list
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
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
     * @param ProductArea $productArea
     * @return ResponseInterface
     */
    public function showAction(ProductArea $productArea): ResponseInterface
    {
        $this->view->assign('productArea', $productArea);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return ResponseInterface
     */
    public function newAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param ProductArea $newProductArea
     */
    public function createAction(ProductArea $newProductArea)
    {

        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', AbstractMessage::WARNING);
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
     * @param ProductArea $productArea
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("productArea")
     * @return ResponseInterface
     */
    public function editAction(ProductArea $productArea): ResponseInterface
    {
        $this->view->assign('productArea', $productArea);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param ProductArea $productArea
     */
    public function updateAction(ProductArea $productArea) : void
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
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', AbstractMessage::WARNING);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param ProductArea $productArea
     */
    public function deleteAction(ProductArea $productArea) : void
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', AbstractMessage::WARNING);
        $this->productAreaRepository->remove($productArea);
        $this->redirect('list');
    }

    /**
     * action validation
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function validationAction(): ResponseInterface
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
