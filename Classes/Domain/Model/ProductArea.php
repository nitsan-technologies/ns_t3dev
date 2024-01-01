<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
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
class ProductArea extends AbstractEntity
{

    /**
     * name
     *
     * @var string
     * @Validate("NotEmpty")
     */
    protected $name = '';

    /**
     * @var ObjectStorage<FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
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

    protected bool $hidden = false;

    /**
     * slug
     *
     * @var string
     */
    protected string $type = '';

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

     /**
     * __construct
     */
    public function __construct()
    {
        // Do not remove the next line: It would break the functionality
        $this->image = new ObjectStorage();
    }

    /**
     * @psalm-return ObjectStorage<FileReference>
     */
    public function getImage(): ObjectStorage
    {
        return $this->image;
    }

    public function setImage(ObjectStorage $image): void
    {
        $this->image = $image;
    }

    public function addImage(FileReference $img): void
    {
        $this->image->attach($img);
    }

    public function removeImage(FileReference $img): void
    {
        $this->image->detach($img);
    }

    /**
     * @param bool $hidden
     */
    public function setHidden($hidden): void
    {
        $this->hidden = $hidden;
    }

    /**
     * @return bool
     */
    public function getHidden(): bool
    {
        return $this->hidden;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
