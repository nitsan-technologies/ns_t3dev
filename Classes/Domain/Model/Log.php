<?php

declare(strict_types=1);

namespace NITSAN\NsT3dev\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class Log
 */
class Log extends AbstractEntity
{
    /**
     * data
     * @var string
     */
    protected string $data = '';

    /**
     * message
     * @var string
     */
    protected string $message = '';

    /**
     * level
     * @var integer
     */
    protected int $level = 0;

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     * @return void
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }


    /**
     * @param int $level
     * @return void
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }
}
