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

/**
 * Class ORMSubscriberException.
 */
class ORMSubscriberException extends ORMException
{
    /**
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_ORM_SUBSCRIBER_GENERIC;
    }

    /**
     * @return int
     */
    public function getDefaultCode()
    {
        return self::CODE_ORM_SUBSCRIBER_GENERIC;
    }
}

/* EOF */
