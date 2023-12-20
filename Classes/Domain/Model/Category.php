<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Domain\Model;
/**
 * This file is part of the "T3 Dev" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Nilesh Malankiya <nilesh@nitsantech.com>, NITSAN Technologies
 */

/**
 * Cayegory
 */
class Category extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * featured_image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $featured_image = null;

    /**
     * Returns the featured_image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getfeatured_image()
    {
        return $this->featured_image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $featured_image
     * @return void
     */
    public function setfeatured_image(\TYPO3\CMS\Extbase\Domain\Model\FileReference $featured_image)
    {
        $this->featured_image = $featured_image;
    }
}
