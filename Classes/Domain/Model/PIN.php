<?php

namespace Homeinfo\Pinlogin\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class PIN extends AbstractEntity
{
    /**
     * @var int $pid
     */
    public $pid;

    /**
     * @var string $feuserId
     */
    public $feuserId;

    /**
     * @var string $pin
     */
    public $pin;
}