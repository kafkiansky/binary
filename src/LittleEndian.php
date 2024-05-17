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
    public function writeInt16(WriteBytes $writer, int $value): void
    {
        $this->writeEndianness($writer, 's', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function writeUint16(WriteBytes $writer, int $value): void
    {
        $writer->write(namespace\pack('v', $value));
    }

    /**
     * {@inheritdoc}
     */
    public function writeInt32(WriteBytes $writer, int $value): void
    {
        $this->writeEndianness($writer, 'l', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function writeUint32(WriteBytes $writer, int $value): void
    {
        $writer->write(namespace\pack('V', $value));
    }

    /**
     * {@inheritdoc}
     */
    public function writeInt64(WriteBytes $writer, int $value): void
    {
        $this->writeEndianness($writer, 'q', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function writeUint64(WriteBytes $writer, int $value): void
    {
        $writer->write(namespace\pack('P', $value));
    }

    public function writeFloat(WriteBytes $writer, float $value): void
    {
        $writer->write(namespace\pack('g', $value));
    }

    public function writeDouble(WriteBytes $writer, float $value): void
    {
        $writer->write(namespace\pack('e', $value));
    }

    /**
     * {@inheritdoc}
     */
    public function readInt16(ReadBytes $reader): int
    {
        return $this->readEndianness($reader->read(2), 's', Type\i16());
    }

    /**
     * {@inheritdoc}
     */
    public function consumeInt16(ConsumeBytes $consumer): int
    {
        return $this->readEndianness($consumer->consume(2), 's', Type\i16());
    }

    /**
     * {@inheritdoc}
     */
    public function readUint16(ReadBytes $reader): int
    {
        return namespace\unpack('v', $reader->read(2), Type\u16());
    }

    /**
     * {@inheritdoc}
     */
    public function consumeUint16(ConsumeBytes $consumer): int
    {
        return namespace\unpack('v', $consumer->consume(2), Type\u16());
    }

    /**
     * {@inheritdoc}
     */
    public function readInt32(ReadBytes $reader): int
    {
        return $this->readEndianness($reader->read(4), 'l', Type\i32());
    }

    /**
     * {@inheritdoc}
     */
    public function consumeInt32(ConsumeBytes $consumer): int
    {
        return $this->readEndianness($consumer->consume(4), 'l', Type\i32());
    }

    /**
     * {@inheritdoc}
     */
    public function readUint32(ReadBytes $reader): int
    {
        return namespace\unpack('V', $reader->read(4), Type\u32());
    }

    /**
     * {@inheritdoc}
     */
    public function consumeUint32(ConsumeBytes $consumer): int
    {
        return namespace\unpack('V', $consumer->consume(4), Type\u32());
    }

    /**
     * {@inheritdoc}
     */
    public function readInt64(ReadBytes $reader): int
    {
        return $this->readEndianness($reader->read(8), 'q', Type\int());
    }

    /**
     * {@inheritdoc}
     */
    public function consumeInt64(ConsumeBytes $consumer): int
    {
        return $this->readEndianness($consumer->consume(8), 'q', Type\int());
    }

    /**
     * {@inheritdoc}
     */
    public function readUint64(ReadBytes $reader): int
    {
        return namespace\unpack('P', $reader->read(8), Type\uint());
    }

    /**
     * {@inheritdoc}
     */
    public function consumeUint64(ConsumeBytes $consumer): int
    {
        return namespace\unpack('P', $consumer->consume(8), Type\uint());
    }

    /**
     * {@inheritdoc}
     */
    public function readFloat(ReadBytes $reader): float
    {
        return namespace\unpack('g', $reader->read(4), Type\f32());
    }

    /**
     * {@inheritdoc}
     */
    public function consumeFloat(ConsumeBytes $consumer): float
    {
        return namespace\unpack('g', $consumer->consume(4), Type\f32());
    }

    /**
     * {@inheritdoc}
     */
    public function readDouble(ReadBytes $reader): float
    {
        return namespace\unpack('e', $reader->read(8), Type\f64());
    }

    /**
     * {@inheritdoc}
     */
    public function consumeDouble(ConsumeBytes $consumer): float
    {
        return namespace\unpack('e', $consumer->consume(8), Type\f64());
    }
}
