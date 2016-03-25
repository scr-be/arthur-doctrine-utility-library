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
 * Class ORMTransactionException.
 */
class ORMTransactionException extends ORMException
{
    /**
     * Get the default exception message.
     *
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_ORM_TRANSACTION;
    }

    /**
     * Get the default exception code.
     *
     * @return int
     */
    public function getDefaultCode()
    {
        return self::CODE_ORM_TRANSACTION;
    }
}

/* EOF */
