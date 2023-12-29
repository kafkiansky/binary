<?php

declare(strict_types=1);

namespace Kafkiansky\Binary\Tests;

use Kafkiansky\Binary\BigEndian;
use Kafkiansky\Binary\Endianness;
use Kafkiansky\Binary\LittleEndian;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Kafkiansky\Binary\Endianness
 */
final class EndiannessTest extends TestCase
{
    public function testImplementation(): void
    {
        self::assertInstanceOf(BigEndian::class, Endianness::big());
        self::assertInstanceOf(BigEndian::class, Endianness::network());
        self::assertInstanceOf(LittleEndian::class, Endianness::little());

        $isLittleEndian = 1 === (\unpack('S', "\x01\x00")[1] ?? 0);
        if ($isLittleEndian) {
            self::assertInstanceOf(LittleEndian::class, Endianness::native());
        } else {
            self::assertInstanceOf(BigEndian::class, Endianness::native());
        }
    }
}
