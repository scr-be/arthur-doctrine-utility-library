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

namespace SR\Doctrine\Exception\Event;

/**
 * Class OrmEventSubscriberException.
 */
class OrmEventSubscriberException extends OrmEventException
{
    /**
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_ORM_EVENT_SUBSCRIBER;
    }
}

/* EOF */