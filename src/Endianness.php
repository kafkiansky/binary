<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

use Psl\Type;

/**
 * @api
 *
 * @psalm-type Int8 = int<-128, 127>
 * @psalm-type Uint8 = int<0, 255>
 * @psalm-type Int16 = int<-32768, 32767>
 * @psalm-type Uint16 = int<0, 65535>
 * @psalm-type Int32 = int<-2147483648, 2147483647>
 * @psalm-type Uint32 = int<0, 4294967295>
 * @psalm-type Int64 = int<min, max>
 * @psalm-type Uint64 = int<0, max>
 *
 * @psalm-inheritors BigEndian|LittleEndian
 */
abstract class Endianness
{
    private static ?bool $isLittleEndian = null;

    final private function __construct()
    {
    }

    /**
     * @param Int8 $value
     */
    final public function writeInt8(WriteBytes $writer, int $value): void
    {
        $writer->write(namespace\pack('c', $value));
    }

    /**
     * @param Uint8 $value
     */
    final public function writeUint8(WriteBytes $writer, int $value): void
    {
        $writer->write(namespace\pack('C', $value));
    }

    /**
     * @param Int16 $value
     */
    abstract public function writeInt16(WriteBytes $writer, int $value): void;

    /**
     * @param Uint16 $value
     */
    abstract public function writeUint16(WriteBytes $writer, int $value): void;

    /**
     * @param Int32 $value
     */
    abstract public function writeInt32(WriteBytes $writer, int $value): void;

    /**
     * @param Uint32 $value
     */
    abstract public function writeUint32(WriteBytes $writer, int $value): void;

    /**
     * @param Int64 $value
     */
    abstract public function writeInt64(WriteBytes $writer, int $value): void;

    /**
     * @param Uint64 $value
     */
    abstract public function writeUint64(WriteBytes $writer, int $value): void;

    abstract public function writeFloat(WriteBytes $writer, float $value): void;

    abstract public function writeDouble(WriteBytes $writer, float $value): void;

    /**
     * @return Int8
     *
     * @throws BinaryException
     */
    final public function readInt8(ReadBytes $reader): int
    {
        return namespace\unpack('c', $reader->read(1), Type\i8());
    }

    /**
     * @return Int8
     *
     * @throws BinaryException
     */
    final public function consumeInt8(ConsumeBytes $consumer): int
    {
        return namespace\unpack('c', $consumer->consume(1), Type\i8());
    }

    /**
     * @return Uint8
     *
     * @throws BinaryException
     */
    final public function readUint8(ReadBytes $reader): int
    {
        return namespace\unpack('C', $reader->read(1), Type\u8());
    }

    /**
     * @return Uint8
     *
     * @throws BinaryException
     */
    final public function consumeUint8(ConsumeBytes $consumer): int
    {
        return namespace\unpack('C', $consumer->consume(1), Type\u8());
    }

    /**
     * @return Int16
     *
     * @throws BinaryException
     */
    abstract public function readInt16(ReadBytes $reader): int;

    /**
     * @return Int16
     *
     * @throws BinaryException
     */
    abstract public function consumeInt16(ConsumeBytes $consumer): int;

    /**
     * @return Uint16
     *
     * @throws BinaryException
     */
    abstract public function readUint16(ReadBytes $reader): int;

    /**
     * @return Uint16
     *
     * @throws BinaryException
     */
    abstract public function consumeUint16(ConsumeBytes $consumer): int;

    /**
     * @return Int32
     *
     * @throws BinaryException
     */
    abstract public function readInt32(ReadBytes $reader): int;

    /**
     * @return Int32
     *
     * @throws BinaryException
     */
    abstract public function consumeInt32(ConsumeBytes $consumer): int;

    /**
     * @return Uint32
     *
     * @throws BinaryException
     */
    abstract public function readUint32(ReadBytes $reader): int;

    /**
     * @return Uint32
     *
     * @throws BinaryException
     */
    abstract public function consumeUint32(ConsumeBytes $consumer): int;

    /**
     * @return Int64
     *
     * @throws BinaryException
     */
    abstract public function readInt64(ReadBytes $reader): int;

    /**
     * @return Int64
     *
     * @throws BinaryException
     */
    abstract public function consumeInt64(ConsumeBytes $consumer): int;

    /**
     * @return Uint64
     *
     * @throws BinaryException
     */
    abstract public function readUint64(ReadBytes $reader): int;

    /**
     * @return Uint64
     *
     * @throws BinaryException
     */
    abstract public function consumeUint64(ConsumeBytes $consumer): int;

    /**
     * @throws BinaryException
     */
    abstract public function readFloat(ReadBytes $reader): float;

    /**
     * @throws BinaryException
     */
    abstract public function consumeFloat(ConsumeBytes $consumer): float;

    /**
     * @throws BinaryException
     */
    abstract public function readDouble(ReadBytes $reader): float;

    /**
     * @throws BinaryException
     */
    abstract public function consumeDouble(ConsumeBytes $consumer): float;

    /**
     * @throws BinaryException
     */
    final public static function network(): BigEndian
    {
        return self::big();
    }

    /**
     * @throws BinaryException
     */
    final public static function native(): static
    {
        return self::createEndianness();
    }

    /**
     * @throws BinaryException
     */
    final public static function big(): BigEndian
    {
        return self::createEndianness(BigEndian::class);
    }

    /**
     * @throws BinaryException
     */
    final public static function little(): LittleEndian
    {
        return self::createEndianness(LittleEndian::class);
    }

    /**
     * @psalm-template T of Endianness
     * @psalm-param ?class-string<T> $endian
     * @psalm-return (T is null ? (LittleEndian|BigEndian) : T)
     *
     * @throws BinaryException
     */
    private static function createEndianness(?string $endian = null)
    {
        self::$isLittleEndian ??= 1 === namespace\unpack('S', "\x01\x00", Type\union(Type\literal_scalar(0), Type\literal_scalar(1)));

        $endian ??= self::$isLittleEndian ? LittleEndian::class : BigEndian::class;

        return new $endian();
    }

    /**
     * @template T
     * @param non-empty-string $format
     * @param T $value
     */
    final protected function writeEndianness(WriteBytes $writer, string $format, mixed $value): void
    {
        $writer->write($this->bytesToEndianness(namespace\pack($format, $value)));
    }

    /**
     * @template T
     * @param non-empty-string $bytes
     * @param non-empty-string $format
     * @param Type\TypeInterface<T> $type
     *
     * @throws BinaryException
     *
     * @return T
     */
    final protected function readEndianness(string $bytes, string $format, Type\TypeInterface $type)
    {
        return namespace\unpack($format, $this->bytesToEndianness($bytes), $type);
    }

    /**
     * @param non-empty-string $bytes
     *
     * @return non-empty-string
     */
    private function bytesToEndianness(string $bytes): string
    {
        $reverse = match ($this::class) {
            LittleEndian::class => !self::$isLittleEndian,
            BigEndian::class => self::$isLittleEndian,
        };

        /** @var non-empty-string */
        return $reverse ? strrev($bytes) : $bytes;
    }
}
