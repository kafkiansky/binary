<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

final class BinaryException extends \Exception
{
    public static function whenNotEnoughBytesToRead(int $need, int $actual): self
    {
        return new self(sprintf('Not enough bytes to read: need - %d, actual - %d.', $need, $actual));
    }

    public static function whenBytesCannotBeUnpacked(string $bytes, string $format): self
    {
        return new self(sprintf('The bytes sequence "%s" cannot be unpacked using format "%s".', $bytes, $format));
    }
}
