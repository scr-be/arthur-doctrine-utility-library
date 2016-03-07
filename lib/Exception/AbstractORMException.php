<?php

/*
 * This file is part of the Arthur Doctrine Library.
 *
 * (c) Scribe Inc. <oss@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Exception;

use Doctrine\ORM\ORMException;
use Scribe\Wonka\Exception\ExceptionTrait;

/**
 * Class AbstractORMException.
 */
abstract class AbstractORMException extends ORMException implements ORMExceptionInterface
{
    use ExceptionTrait;
}

/* EOF */
