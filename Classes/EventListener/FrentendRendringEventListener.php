<?php

namespace NITSAN\NsT3dev\EventListener;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use NITSAN\NsT3dev\Event\FrentendRendringEvent;

class FrentendRendringEventListener
{
   
    public function __invoke(FrentendRendringEvent $event): void
    {   
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile("EXT:ns_t3dev/Resources/Public/Css/myCustom.css");
        
    }
}

?>