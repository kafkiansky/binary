<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

use Psl\Type;

/**
 * @api
 */
final class LittleEndian extends Endianness
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
        $writer->write(namespace\pack('v', $value));
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
        $writer->write(namespace\pack('V', $value));
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
        $writer->write(namespace\pack('P', $value));
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
        return namespace\unpack('v', $reader->read(2), Type\u16());
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
        return namespace\unpack('V', $reader->read(4), Type\u32());
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
        return namespace\unpack('P', $reader->read(8), Type\uint());
    }
}