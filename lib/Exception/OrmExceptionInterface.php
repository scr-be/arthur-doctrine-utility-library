<?php

/*
 * This file is part of the `src-run/arthur-doctrine-utils-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 * (c) Scribe Inc      <scr@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\Exception;

use SR\Exception\ExceptionInterface;

/**
 * Interface OrmExceptionInterface.
 */
interface OrmExceptionInterface extends ExceptionInterface
{
    /**
     * @var int
     */
    const CODE_ORM = 5000;

    /**
     * @var string
     */
    const MSG_ORM = 'ORM: %s';

    /**
     * @var string
     */
    const MSG_ORM_ACTION = 'ORM action: %s.';

    /**
     * @var string
     */
    const MSG_ORM_ACTION_PERSIST = 'ORM persist action: %s.';

    /**
     * @var string
     */
    const MSG_ORM_ACTION_REMOVE = 'ORM remove action: %s.';

    /**
     * @var string
     */
    const MSG_ORM_ACTION_UPDATE = 'ORM update action: %s.';

    /**
     * @var string
     */
    const MSG_ORM_STATE = 'ORM state: %s.';

    /**
     * @var string
     */
    const MSG_ORM_STATE_ASSOCIATION = 'ORM association state: %s.';

    /**
     * @var string
     */
    const MSG_ORM_STATE_TRANSACTION = 'ORM transaction state: %s.';

    /**
     * @var string
     */
    const MSG_ORM_EVENT = 'ORM event: %s.';

    /**
     * @var string
     */
    const MSG_ORM_EVENT_LISTENER = 'ORM "%s" event listener: %s.';

    /**
     * @var string
     */
    const MSG_ORM_EVENT_SUBSCRIBER = 'ORM "%s" event subscriber: %s.';

    /**
     * @var string
     */
    const MSG_ORM_TYPE = 'ORM type conversion failed.';
}

/* EOF */
