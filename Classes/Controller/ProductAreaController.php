<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Controller;

use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

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


    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $productAreas = $this->productAreaRepository->findAll();
        $currentPage = $this->request->hasArgument('currentPage')
            ? (int)$this->request->getArgument('currentPage')
            : 1;
        $itemsPerPage = $this->settings['itemsPerPage'];
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
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this, __FILE__.' Line'.__LINE__);die;
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
     * action validation
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function validationAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

}
