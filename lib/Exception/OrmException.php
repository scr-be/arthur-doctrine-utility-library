<?php

/*
 * This file is part of the `src-run/arthur-doctrine-exception-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\Exception;

use SR\Exception\Exception;
use SR\Exception\ExceptionInterface;

/**
 * Exception thrown for generic ORM failures.
 */
class OrmException extends Exception implements ExceptionInterface
{
    /**
     * @param string|null $message
     * @param array|mixed ...$parameters
     */
    public function __construct(string $message = null, ...$parameters)
    {
        parent::__construct($this->compileOrmMessage($message), ...$parameters);
    }

    /**
     * @param string|null $message
     *
     * @return string
     */
    private function compileOrmMessage(string $message = null): string
    {
        return sprintf('[ORM %s]', $this->getOrmType()).($message ? sprintf(' %s', $message) : '');
    }

    /**
     * @return string
     */
    private function getOrmType(): ? string
    {
        if (1 === preg_match('{Orm(?<name>[A-Za-z]+)Exception}', get_called_class(), $typeMatches)) {
            if (0 < preg_match_all('{(?:^|[A-Z])[a-z]+}', $typeMatches['name'], $wordMatches)) {
                return implode(' ', array_shift($wordMatches));
            }
        }

        return 'Generic';
    }
}
