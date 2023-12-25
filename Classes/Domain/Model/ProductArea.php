<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;
use NITSAN\NsT3dev\Domain\Validator\DescriptionValidator;
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
    protected string $name = '';

    /**
     * image
     *
     * @var FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $image = null;

    /**
     * description
     *
     * @var string
     * @Validate("NITSAN\NsT3dev\Domain\Validator\DescriptionValidator")
     */
    protected string $description = '';

    /**
     * slug
     *
     * @var string
     */
    protected string $slug = '';

    /**
     * Returns the name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns the image
     *
     * @return FileReference|null
     */
    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param FileReference $image
     * @return void
     */
    public function setImage(FileReference $image): void
    {
        $this->image = $image;
    }

    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns the slug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Sets the slug
     *
     * @param string $slug
     * @return void
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}
