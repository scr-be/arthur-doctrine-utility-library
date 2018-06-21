<?php

/*
 * This file is part of the `src-run/arthur-doctrine-exception-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\Exception\Query;

use Doctrine\ORM\Query\QueryException as DoctrineQueryException;
use SR\Doctrine\Exception\ExceptionInterface;
use SR\Doctrine\Exception\ExceptionTrait;

class QueryException extends DoctrineQueryException implements ExceptionInterface
{
    use ExceptionTrait;
}
