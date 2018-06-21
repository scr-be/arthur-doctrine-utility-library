<?php

/*
 * This file is part of the `src-run/arthur-doctrine-exception-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\Exception\Tests;

use PHPUnit\Framework\TestCase;
use SR\Doctrine\Exception\Action\ActionException;
use SR\Doctrine\Exception\Action\ActionPersistException;
use SR\Doctrine\Exception\Action\ActionRemovalException;
use SR\Doctrine\Exception\Action\ActionUpdateException;
use SR\Doctrine\Exception\Cache\CacheException;
use SR\Doctrine\Exception\Event\EventException;
use SR\Doctrine\Exception\Event\EventListenerException;
use SR\Doctrine\Exception\Event\EventSubscriberException;
use SR\Doctrine\Exception\ExceptionInterface;
use SR\Doctrine\Exception\GeneralException;
use SR\Doctrine\Exception\Hydration\HydrationException;
use SR\Doctrine\Exception\InvalidArgumentException;
use SR\Doctrine\Exception\Mapping\MappingException;
use SR\Doctrine\Exception\Query\QueryException;
use SR\Doctrine\Exception\Result\ResultUnavailableException;
use SR\Doctrine\Exception\Result\ResultUnexpectedException;
use SR\Doctrine\Exception\Result\ResultUniqueException;
use SR\Doctrine\Exception\Schema\SchemaException;
use SR\Doctrine\Exception\State\StateAssociationException;
use SR\Doctrine\Exception\State\StateException;
use SR\Doctrine\Exception\State\StateTransactionException;
use SR\Doctrine\Exception\Type\TypeConversionException;
use SR\Doctrine\Exception\Type\TypeException;
use SR\Doctrine\Exception\Type\TypeGeneratorException;

/**
 * @covers \SR\Doctrine\Exception\GeneralException
 * @covers \SR\Doctrine\Exception\InvalidArgumentException
 * @covers \SR\Doctrine\Exception\ExceptionTrait
 * @covers \SR\Doctrine\Exception\Action\ActionException
 * @covers \SR\Doctrine\Exception\Action\ActionPersistException
 * @covers \SR\Doctrine\Exception\Action\ActionRemovalException
 * @covers \SR\Doctrine\Exception\Action\ActionUpdateException
 * @covers \SR\Doctrine\Exception\Cache\CacheException
 * @covers \SR\Doctrine\Exception\Event\EventException
 * @covers \SR\Doctrine\Exception\Event\EventListenerException
 * @covers \SR\Doctrine\Exception\Event\EventSubscriberException
 * @covers \SR\Doctrine\Exception\Hydration\HydrationException
 * @covers \SR\Doctrine\Exception\Mapping\MappingException
 * @covers \SR\Doctrine\Exception\Query\QueryException
 * @covers \SR\Doctrine\Exception\Result\ResultUnavailableException
 * @covers \SR\Doctrine\Exception\Result\ResultUnexpectedException
 * @covers \SR\Doctrine\Exception\Result\ResultUniqueException
 * @covers \SR\Doctrine\Exception\Schema\SchemaException
 * @covers \SR\Doctrine\Exception\State\StateAssociationException
 * @covers \SR\Doctrine\Exception\State\StateException
 * @covers \SR\Doctrine\Exception\State\StateTransactionException
 * @covers \SR\Doctrine\Exception\Type\TypeConversionException
 * @covers \SR\Doctrine\Exception\Type\TypeException
 * @covers \SR\Doctrine\Exception\Type\TypeGeneratorException
 */
class ExceptionTest extends TestCase
{
    /**
     * @var string[]
     */
    private static $exceptionFQCNs = [
        GeneralException::class,
        InvalidArgumentException::class,
        ActionException::class,
        ActionPersistException::class,
        ActionRemovalException::class,
        ActionUpdateException::class,
        CacheException::class,
        EventException::class,
        EventListenerException::class,
        EventSubscriberException::class,
        HydrationException::class,
        MappingException::class,
        QueryException::class,
        ResultUnavailableException::class,
        ResultUnexpectedException::class,
        ResultUniqueException::class,
        SchemaException::class,
        StateAssociationException::class,
        StateException::class,
        StateTransactionException::class,
        TypeConversionException::class,
        TypeException::class,
        TypeGeneratorException::class,
    ];

    /**
     * @return \Generator|ExceptionInterface[]
     */
    public static function provideQualifiedExceptionClassNamesData(): \Generator
    {
        foreach (self::$exceptionFQCNs as $exceptionFQCN) {
            foreach (self::provideExceptionConstructorArguments() as [$format, $arguments]) {
                yield [$exceptionFQCN, $format, $arguments];
            }
        }
    }

    /**
     * @dataProvider provideQualifiedExceptionClassNamesData
     *
     * @param string $name
     * @param string $format
     * @param array  $arguments
     */
    public function testDoctrineExceptionMessagesAndCodes(string $name, ?string $format, array $arguments): void
    {
        $exception = self::createExceptionInstance($name, $format, $arguments);

        $this->assertInstanceOf(ExceptionInterface::class, $exception);

        $this->assertExceptionHasExpectedMessage($exception);
        $this->assertExceptionHasExpectedCategories($exception);
        $this->assertExceptionHasExpectedDescription($exception);
    }

    /**
     * @param ExceptionInterface $exception
     */
    private function assertExceptionHasExpectedMessage(ExceptionInterface $exception): void
    {
        $expects = $exception->getMessage();
        $message = preg_replace('{^\[[^\]]+\]\s}', '', $message ?? $expects);

        $this->assertStringEndsWith($message, $expects);
        $this->assertStringMatchesFormat('[%s: %s] %s', $expects);
        $this->assertRegExp(sprintf(
            '{%s .+}', preg_quote(sprintf('[ORM: %s]', $exception->getDescription()))
        ), $expects);

        $this->assertGreaterThanOrEqual(1, $exception->getCategories());
    }

    /**
     * @param ExceptionInterface $exception
     */
    private function assertExceptionHasExpectedCategories(ExceptionInterface $exception): void
    {
        $this->assertGreaterThanOrEqual(1, $exception->getCategories());
        $this->assertCount(count(explode(' ', $exception->getDescription())), $exception->getCategories());
    }

    /**
     * @param ExceptionInterface $exception
     */
    private function assertExceptionHasExpectedDescription(ExceptionInterface $exception): void
    {
        foreach ($exception->getCategories() as $category) {
            $this->assertRegExp(sprintf('{(.+)?(%s)(.+)?}i', preg_quote($category)), $exception->getDescription());
        }
    }

    /**
     * @return \Generator
     */
    private static function provideExceptionConstructorArguments(): \Generator
    {
        yield [null, []];
        yield ['Simple custom exception message!', []];
        yield ['Message with string(%s) and integer (%d) and float (%f) replacements!', [
            'foobar',
            12345,
            12.34,
        ]];
    }

    /**
     * @param string      $fqcn
     * @param string|null $message
     * @param array       $parameters
     *
     * @return ExceptionInterface|ExceptionInterface
     */
    private static function createExceptionInstance(string $fqcn, $message, array $parameters): ExceptionInterface
    {
        return new $fqcn($message, ...$parameters);
    }
}

/* EOF */
