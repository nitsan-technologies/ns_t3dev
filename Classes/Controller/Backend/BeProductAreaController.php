<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Controller\Backend;

use NITSAN\NsT3dev\Domain\Model\ProductArea;
use NITSAN\NsT3dev\Domain\Repository\ProductAreaRepository;
use NITSAN\NsT3dev\Event\FrontendRendringEvent;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;

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
class BeProductAreaController extends ActionController
{

    /**
     * productAreaRepository
     *
     * @var ProductAreaRepository
     */
    protected ?ProductAreaRepository $productAreaRepository = null;

    /**
     * @param ProductAreaRepository $productAreaRepository
     */
    public function injectProductAreaRepository(ProductAreaRepository $productAreaRepository): void
    {
        $this->productAreaRepository = $productAreaRepository;
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
        $itemsPerPage = 5;
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

        $id = (int)\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('id');

        $this->view->assign('page_id', $id);
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
     * action delete
     *
     * @param ProductArea $productArea
     * @throws IllegalObjectTypeException
     * @throws StopActionException
     */
    public function deleteAction(ProductArea $productArea) : void
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check.', '', AbstractMessage::WARNING);
        $this->productAreaRepository->remove($productArea);
        $this->redirect('list');
    }

    /**
     * action list
     *
     * @return ResponseInterface
     */
    public function ajaxListAction(): ResponseInterface
    {
        $this->eventDispatcher->dispatch(
            new FrontendRendringEvent()
        );
        $productAreas = $this->productAreaRepository->findAll();
        $currentPage = $this->request->hasArgument('currentPage')
            ? (int)$this->request->getArgument('currentPage')
            : 1;
        $itemsPerPage = 5;
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

        $id = (int)\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('id');

        $this->view->assign('page_id', $id);
        $this->view->assign('productAreas', $productAreas);
        return $this->htmlResponse();
    }


}
