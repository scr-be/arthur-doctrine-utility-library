<?php

/*
 * This file is part of the `src-run/arthur-doctrine-exception-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 * (c) Scribe Inc      <scr@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\Exception\Tests;

use SR\Exception\ExceptionInterface;

/**
 * Class ExceptionTest.
 */
class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string[]
     */
    private static $relativeExceptionClassNames = [
        'OrmException',
        'Action\\OrmActionException',
        'Action\\OrmActionPersistException',
        'Action\\OrmActionRemoveException',
        'Action\\OrmActionUpdateException',
        'Event\\OrmEventException',
        'Event\\OrmEventListenerException',
        'Event\\OrmEventSubscriberException',
        'State\\OrmStateException',
        'State\\OrmStateAssociationException',
        'State\\OrmStateTransactionException',
        'Type\\OrmTypeConversionException',
        'Type\\OrmTypeGeneratorException',
        'Type\\OrmTypeException',
    ];

    /**
     * @return array
     */
    public static function provideQualifiedExceptionClassNamesData()
    {
        return array_map(function (string $relative) {
            return [sprintf('%s\\%s', str_replace('\\Tests', '', __NAMESPACE__), $relative)];
        }, static::$relativeExceptionClassNames);
    }

    /**
     * @dataProvider provideQualifiedExceptionClassNamesData
     *
     * @param string $qualified
     */
    public function testDoctrineExceptionMessagesAndCodes(string $qualified)
    {
        $exception = $this->createExceptionInstance($qualified);
        $this->assertInstanceOf(ExceptionInterface::class, $exception);
        $this->assertRegExp('{\[ORM .+\].*}', $exception->getMessage());
        var_dump($exception->getMessage());

        $exception = $this->createExceptionInstance($qualified, 'Custom message');
        $this->assertRegExp('{\[ORM .+\] Custom message}', $exception->getMessage());

        $exception = $this->createExceptionInstance($qualified, 'Message with string(%s) and integer(%s)', 'string', 1000);
        $this->assertRegExp('{\[ORM .+\] Message with string\(string\) and integer\(1000\)}', $exception->getMessage());
    }

    /**
     * @param string      $qualifiedClassName
     * @param string|null $message
     * @param array       ...$parameters
     *
     * @return ExceptionInterface
     */
    private function createExceptionInstance(string $qualifiedClassName, $message = null, ...$parameters)
    {
        return new $qualifiedClassName($message, ...$parameters);
    }
}

/* EOF */
