<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Tests\Unit\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 *
 * @author Nilesh Malankiya <nilesh@nitsantech.com>
 */
class ProductAreaControllerTest extends UnitTestCase
{
    /**
     * @var \NITSAN\NsT3dev\Controller\ProductAreaController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\NITSAN\NsT3dev\Controller\ProductAreaController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllProductAreasFromRepositoryAndAssignsThemToView(): void
    {
        $allProductAreas = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $productAreaRepository = $this->getMockBuilder(\NITSAN\NsT3dev\Domain\Repository\ProductAreaRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $productAreaRepository->expects(self::once())->method('findAll')->will(self::returnValue($allProductAreas));
        $this->subject->_set('productAreaRepository', $productAreaRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('productAreas', $allProductAreas);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenProductAreaToView(): void
    {
        $productArea = new \NITSAN\NsT3dev\Domain\Model\ProductArea();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('productArea', $productArea);

        $this->subject->showAction($productArea);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenProductAreaToProductAreaRepository(): void
    {
        $productArea = new \NITSAN\NsT3dev\Domain\Model\ProductArea();

        $productAreaRepository = $this->getMockBuilder(\NITSAN\NsT3dev\Domain\Repository\ProductAreaRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $productAreaRepository->expects(self::once())->method('add')->with($productArea);
        $this->subject->_set('productAreaRepository', $productAreaRepository);

        $this->subject->createAction($productArea);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenProductAreaToView(): void
    {
        $productArea = new \NITSAN\NsT3dev\Domain\Model\ProductArea();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('productArea', $productArea);

        $this->subject->editAction($productArea);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenProductAreaInProductAreaRepository(): void
    {
        $productArea = new \NITSAN\NsT3dev\Domain\Model\ProductArea();

        $productAreaRepository = $this->getMockBuilder(\NITSAN\NsT3dev\Domain\Repository\ProductAreaRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $productAreaRepository->expects(self::once())->method('update')->with($productArea);
        $this->subject->_set('productAreaRepository', $productAreaRepository);

        $this->subject->updateAction($productArea);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenProductAreaFromProductAreaRepository(): void
    {
        $productArea = new \NITSAN\NsT3dev\Domain\Model\ProductArea();

        $productAreaRepository = $this->getMockBuilder(\NITSAN\NsT3dev\Domain\Repository\ProductAreaRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $productAreaRepository->expects(self::once())->method('remove')->with($productArea);
        $this->subject->_set('productAreaRepository', $productAreaRepository);

        $this->subject->deleteAction($productArea);
    }
}
