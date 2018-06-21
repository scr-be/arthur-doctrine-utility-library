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

use SR\Exception\ExceptionTrait as BaseExceptionTrait;

trait ExceptionTrait
{
    use BaseExceptionTrait {
        resolveMessage as baseResolveMessage;
    }

    /**
     * @return string[]
     */
    final public function getCategories(): array
    {
        preg_match('{\\\(?<name>[a-z]+)Exception$}i', get_called_class(), $match);

        return array_reverse(array_map(function (string $c): string {
            return mb_strtolower($c);
        }, preg_split('{(?=[A-Z])}', lcfirst($match['name'] ?? ''))));
    }

    /**
     * @return string
     */
    final public function getDescription(): string
    {
        return trim(preg_replace('{\s+}', ' ', implode(' ', array_map(function (string $category): string {
            return ucfirst($category);
        }, $this->getCategories()))));
    }

    /**
     * @param string|null $message
     * @param mixed[]     $parameters
     *
     * @return string
     */
    final protected function resolveMessage(string $message = null, array $parameters = []): string
    {
        return $this->baseResolveMessage(sprintf(
            '[ORM: %s] %s', $this->getDescription(), $message ?: 'An unclassified exception occured.'
        ), $parameters);
    }
}
