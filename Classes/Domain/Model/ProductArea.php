<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;
use NITSAN\NsT3dev\Domain\Validator\DescriptionValidator;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

/**
 * This file is part of the "T3 Dev" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Nilesh Malankiya <nilesh@nitsantech.com>, NITSAN Technologies
 */

/**
 * ProductArea
 */
class ProductArea extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     * @Validate("NotEmpty")
     */
    protected $name = null;

    // /**
    //  * image
    //  *
    //  * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
    //  * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
    //  */
    // protected $image = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $image = null;

    /**
     * description
     *
     * @var string
     * @Validate("NITSAN\NsT3dev\Domain\Validator\DescriptionValidator")
     */
    protected $description = null;

    /**
     * slug
     *
     * @var string
     */
    protected $slug = null;

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    // /**
    //  * Returns the image
    //  *
    //  * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
    //  */
    // public function getImage()
    // {
    //     return $this->image;
    // }

    // /**
    //  * Sets the image
    //  *
    //  * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
    //  * @return void
    //  */
    // public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    // {
    //     $this->image = $image;
    // }

    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Returns the slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets the slug
     *
     * @param string $slug
     * @return void
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

     /**
     * __construct
     */
    public function __construct()
    {
        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
        $this->image = new ObjectStorage();
    }

    /**
     * @psalm-return ObjectStorage<FileReference>
     */
    public function getImage(): ObjectStorage
    {
        return $this->image;
    }

    public function setImage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $image): void
    {
        $this->image = $image;
    }

    public function addImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $img): void
    {
        $this->image->attach($img);
    }

    public function removeImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $img): void
    {
        $this->image->detach($img);
    }
}
