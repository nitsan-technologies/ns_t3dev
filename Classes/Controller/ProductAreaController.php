<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Controller;


use NITSAN\NsT3dev\Domain\Model\ProductArea;
use NITSAN\NsT3dev\Domain\Repository\ProductAreaRepository;
use Psr\Http\Message\ResponseInterface;
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
    }

    /**
     * action list
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $productAreas = $this->productAreaRepository->findAll();
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
        $this->productAreaRepository->add($newProductArea);
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
    public function updateAction(ProductArea $productArea)
    {
        $this->productAreaRepository->update($productArea);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param ProductArea $productArea
     */
    public function deleteAction(ProductArea $productArea)
    {
        $this->productAreaRepository->remove($productArea);
        $this->redirect('list');
    }
}
