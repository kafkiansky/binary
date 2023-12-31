<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

use Psl\Type;

/**
 * @api
 */
final class BigEndian extends Endianness
{
    /**
     * {@inheritdoc}
     */
    public function writeInt16(Writer $writer, int $value): void
    {
        $this->writeEndianness($writer, 's', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function writeUint16(Writer $writer, int $value): void
    {
        $writer->write(namespace\pack('n', $value));
    }

    /**
     * {@inheritdoc}
     */
    public function writeInt32(Writer $writer, int $value): void
    {
        $this->writeEndianness($writer, 'l', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function writeUint32(Writer $writer, int $value): void
    {
        $writer->write(namespace\pack('N', $value));
    }

    /**
     * {@inheritdoc}
     */
    public function writeInt64(Writer $writer, int $value): void
    {
        $this->writeEndianness($writer, 'q', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function writeUint64(Writer $writer, int $value): void
    {
        $writer->write(namespace\pack('J', $value));
    }

    public function writeFloat(Writer $writer, float $value): void
    {
        $writer->write(namespace\pack('G', $value));
    }

    public function writeDouble(Writer $writer, float $value): void
    {
        $writer->write(namespace\pack('E', $value));
    }

    /**
     * {@inheritdoc}
     */
    public function readInt16(Reader $reader): int
    {
        return $this->readEndianness($reader->read(2), 's', Type\i16());
    }

    /**
     * {@inheritdoc}
     */
    public function readUint16(Reader $reader): int
    {
        return namespace\unpack('n', $reader->read(2), Type\u16());
    }

    /**
     * {@inheritdoc}
     */
    public function readInt32(Reader $reader): int
    {
        return $this->readEndianness($reader->read(4), 'l', Type\i32());
    }

    /**
     * {@inheritdoc}
     */
    public function readUint32(Reader $reader): int
    {
        return namespace\unpack('N', $reader->read(4), Type\u32());
    }

    /**
     * {@inheritdoc}
     */
    public function readInt64(Reader $reader): int
    {
        return $this->readEndianness($reader->read(8), 'q', Type\int());
    }

    /**
     * {@inheritdoc}
     */
    public function readUint64(Reader $reader): int
    {
        return namespace\unpack('J', $reader->read(8), Type\uint());
    }

    /**
     * {@inheritdoc}
     */
    public function readFloat(Reader $reader): float
    {
        return namespace\unpack('G', $reader->read(4), Type\f32());
    }

    /**
     * {@inheritdoc}
     */
    public function readDouble(Reader $reader): float
    {
        return namespace\unpack('E', $reader->read(8), Type\f64());
    }
}
