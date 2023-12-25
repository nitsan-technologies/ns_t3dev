<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Tests\Unit\Controller;

use NITSAN\NsT3dev\Controller\ProductAreaController;
use NITSAN\NsT3dev\Domain\Model\ProductArea;
use NITSAN\NsT3dev\Domain\Repository\ProductAreaRepository;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Fluid\View\TemplateView;
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
     * @var ProductAreaController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    /**
     * @var TemplateView&MockObject
     */
    private TemplateView $viewMock;

    /**
     * @var ProductAreaRepository&MockObject
     */
    private ProductAreaRepository $productAreaRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productAreaRepositoryMock = $this->createMock(ProductAreaRepository::class);
        // We need to create an accessible mock in order to be able to set the protected `view`.
        $methodsToMock = ['htmlResponse', 'redirect', 'redirectToUri'];
        if ((new Typo3Version())->getMajorVersion() < 12) {
            $methodsToMock[] = 'forward';
        }

        $this->subject = $this->getAccessibleMock(ProductAreaController::class, $methodsToMock,
            [$this->productAreaRepositoryMock]);

        $this->viewMock = $this->createMock(TemplateView::class);
        $this->subject->_set('view', $this->viewMock);

        $responseStub = $this->createStub(HtmlResponse::class);
        $this->subject->method('htmlResponse')->willReturn($responseStub);
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
        $allProductAreas = $this->createStub(QueryResultInterface::class);
        $this->productAreaRepositoryMock->method('findAll')->willReturn($allProductAreas);
        $this->viewMock->expects(self::once())->method('assign')->with('productAreas', $allProductAreas);
        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenProductAreaToView(): void
    {
        $productArea = new ProductArea();

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
        $newProductArea = new ProductArea();

        $flashMessageMock = $this->getMockBuilder(AbstractMessage::class)->getMock();
        $this->subject->_set('flashMessage', $flashMessageMock);

        $this->productAreaRepositoryMock->expects(self::once())->method('add')->with($newProductArea);

        $this->subject->createAction($newProductArea);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenProductAreaToView(): void
    {
        $productArea = new ProductArea();

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
        $productArea = new ProductArea();

        $productAreaRepository = $this->getMockBuilder(ProductAreaRepository::class)
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
        $productArea = new ProductArea();

        $productAreaRepository = $this->getMockBuilder(ProductAreaRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $productAreaRepository->expects(self::once())->method('remove')->with($productArea);
        $this->subject->_set('productAreaRepository', $productAreaRepository);

        $this->subject->deleteAction($productArea);
    }
}
