<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

use Psl\Type;

/**
 * @template T
 * @param non-empty-string $format
 * @param T                $value
 *
 * @return non-empty-string
 */
function pack(string $format, mixed $value): string
{
    return Type\non_empty_string()->coerce(\pack($format, $value));
}

/**
 * @template T
 * @param non-empty-string      $format
 * @param non-empty-string      $bytes
 * @param Type\TypeInterface<T> $type
 *
 * @return T
 */
function unpack(string $format, string $bytes, Type\TypeInterface $type)
{
    $value = \unpack($format, $bytes) ?: throw new \RuntimeException('Cannot unpack bytes.');

    return $type->coerce($value[1] ?? 0);
}
