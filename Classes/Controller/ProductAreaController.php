<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Controller;

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

    public function dashboardAction(){
        if(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('gridelements')){
            $grids = $this->productAreaRepository->getGrids();
            if($grids){
                $assign = [
                    'action' => 'dashboard',
                    'extension' => 'gridelements',
                ];
                $this->view->assignMultiple($assign);
            }            
        }
        else{
            $assign = [
                'action' => 'dashboard',
                'extension' => '',
            ];
            $this->view->assignMultiple($assign);
        }

    }

    public function executeMigrationAction(){
        $grids = $this->productAreaRepository->getGrids();
        if($grids){
            $result = $this->productAreaRepository->executeUpdate();
            if($result){
                $assign = [
                    'action' => 'executeMigration',
                    'result' => $result,
                ];
            }
        }
        else{
            $assign = [
                'action' => 'executeMigration',
                'result' => '',
            ];
        
        }
        $this->view->assignMultiple($assign);
    }

    public function specificGridMigrateAction(){
        $gridelementsElements = $this->productAreaRepository->findGridelements();
        if(empty($gridelementsElements)){
                $assign = [
                    'action' => 'executeMigration',
                    'grid' => '',
                ];
        }
        else{

            $gridElementsArray=[];
            $layoutColumns = [];
            foreach ($gridelementsElements as $gridElement) {
                
                $columnElement = $this->productAreaRepository->findContentfromGridElements($gridElement['uid']);
                if($columnElement) {
                    $columnElementFlip = array_fill_keys(array_column($columnElement, 'tx_gridelements_columns'), '1');
                    if(!isset($layoutColumns[$gridElement['tx_gridelements_backend_layout']])) $layoutColumns[$gridElement['tx_gridelements_backend_layout']] = [];
                    if(array_diff_assoc($columnElementFlip, $layoutColumns[$gridElement['tx_gridelements_backend_layout']])) {
                        $gridElementsArray[$gridElement['tx_gridelements_backend_layout']] = $gridElement;
                        $layoutColumns[$gridElement['tx_gridelements_backend_layout']] += $columnElementFlip;
                    }
                }
            }
            $assign = [
                "gridelementsElements" => $gridElementsArray,
                "layoutColumns" => $layoutColumns,
                "grid" => "find",
            ];
        }
        $this->view->assignMultiple($assign);
    }

    public function processMirgrateAction(){
        $arguments = $this->request->getArguments();
        $migrateAllElements = $this->productAreaRepository->updateAllElements($arguments['migrategeneral']['elements']);
        $this->view->assignMultiple(
            array(
                "arguments" => $arguments,
                "migrateAllElements" => $migrateAllElements
            )
        );
    }
}