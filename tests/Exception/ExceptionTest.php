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

use SR\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class ExceptionTest.
 */
class ExceptionTest extends WonkaTestCase
{
    const CLASS_NAMESPACE = '\\SR\\Doctrine\\Exception\\';

    public $exceptionClasses = [
        'ORMAssociationException',
        'ORMDataStateException',
        'ORMException',
        'ORMSubscriberEventException',
        'ORMSubscriberException',
        'ORMTransactionException',
    ];

    public function testExceptions()
    {
        foreach ($this->exceptionClasses as $class) {
            $classFQCN = self::CLASS_NAMESPACE.$class;
            $e = new $classFQCN();

            static::assertNotNull($e->getMessage());
            static::assertNotNull($e->getCode());
        }
    }
}

/* EOF */
