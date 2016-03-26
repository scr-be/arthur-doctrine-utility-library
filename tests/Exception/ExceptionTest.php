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

use SR\Wonka\Exception\ExceptionInterface;
use SR\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class ExceptionTest.
 */
class ExceptionTest extends WonkaTestCase
{
    /**
     * @var string
     */
    const CLASS_NAMESPACE = '\\SR\\Doctrine\\Exception\\';

    /**
     * @var string[]
     */
    public $ormExceptions = [
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
        'Type\\OrmTypeException',
    ];

    public function testDoctrineExceptionMessagesAndCodes()
    {
        foreach ($this->ormExceptions as $className) {
            $classFqcn = self::CLASS_NAMESPACE . $className;
            $constName = $this->getMessageConstantFromClassName($classFqcn);
            $exception = $this->getExceptionInstance($classFqcn);
            $normalize = function () use ($classFqcn, $constName) {
                $value = constant($classFqcn . '::' . $constName);

                return preg_replace_callback('{%[0-9ds][0-9]?(?:\$[0-9]?[0-9]?[a-z]?)?}i', function (array $matches) {
                    return '<null>';
                }, $value);
            };

            static::assertInstanceOf($classFqcn, $exception);
            static::assertNotNull($exception->getMessage());
            static::assertNotNull($exception->getCode());
            static::assertSame($normalize(),
                $exception->getMessage());

            $exception = $this->getExceptionInstance($classFqcn, null,
                ['PHPUnit test message for exception.', 'PHPUnit test message for exception.']);

            if (strpos($className, 'TypeException')) {
                continue;
            }

            static::assertRegExp(
                '{.+: PHPUnit test message for exception}',
                $exception->getMessage());

            $exception = $this->getExceptionInstance($classFqcn,
                'PHPUnit custom replacements: %s, %s',
                ['first string', 'second string']);

            static::assertSame('PHPUnit custom replacements: first string, second string',
                $exception->getMessage());
        }
    }

    /**
     * @param string $classFqcn
     *
     * @return string
     */
    private function getMessageConstantFromClassName($classFqcn)
    {
        $name = preg_replace('{.*\\\}', '', $classFqcn);
        $name = str_replace('Exception', '', $name);
        $name = ltrim(preg_replace('/[A-Z]/', '_$0', $name), '_');

        return strtoupper('MSG_' . $name);
    }

    /**
     * @param string     $classFqcn
     * @param array|null $parameters
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|ExceptionInterface
     */
    private function getExceptionInstance($classFqcn, $message = null, array $parameters = null)
    {
        $parameters = null !== $parameters ? $parameters : [];

        return $classFqcn::create($message, ...$parameters);
    }
}

/* EOF */
