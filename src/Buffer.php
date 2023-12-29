<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

/**
 * @api
 */
final class Buffer implements
    Writer,
    Reader,
    \Stringable,
    \Countable
{
    private readonly Endianness $endianness;

    /** @var int<0, max> */
    private int $size;

    private function __construct(
        private string $bytes = '',
        ?Endianness $endianness = null,
    ) {
        $this->endianness = $endianness ?: Endianness::network();
        $this->size = strlen($this->bytes);
    }

    public static function empty(?Endianness $endianness = null): self
    {
        return new self(endianness: $endianness);
    }

    public static function fromString(string $bytes, ?Endianness $endianness = null): self
    {
        return new self($bytes, $endianness);
    }

    public function writeInt8(int $value): self
    {
        $this->endianness->writeInt8($this, $value);

        return $this;
    }

    public function writeUint8(int $value): self
    {
        $this->endianness->writeUint8($this, $value);

        return $this;
    }

    public function writeInt16(int $value): self
    {
        $this->endianness->writeInt16($this, $value);

        return $this;
    }

    public function writeUint16(int $value): self
    {
        $this->endianness->writeUint16($this, $value);

        return $this;
    }

    public function writeInt32(int $value): self
    {
        $this->endianness->writeInt32($this, $value);

        return $this;
    }

    public function writeUint32(int $value): self
    {
        $this->endianness->writeUint32($this, $value);

        return $this;
    }

    public function writeInt64(int $value): self
    {
        $this->endianness->writeInt64($this, $value);

        return $this;
    }

    public function writeUint64(int $value): self
    {
        $this->endianness->writeUint64($this, $value);

        return $this;
    }

    public function readInt8(): int
    {
        return $this->endianness->readInt8($this);
    }

    public function readUint8(): int
    {
        return $this->endianness->readUint8($this);
    }

    public function readInt16(): int
    {
        return $this->endianness->readInt16($this);
    }

    public function readUint16(): int
    {
        return $this->endianness->readUint16($this);
    }

    public function readInt32(): int
    {
        return $this->endianness->readInt32($this);
    }

    public function readUint32(): int
    {
        return $this->endianness->readUint32($this);
    }

    public function readInt64(): int
    {
        return $this->endianness->readInt64($this);
    }

    public function readUint64(): int
    {
        return $this->endianness->readUint64($this);
    }

    /**
     * {@inheritdoc}
     */
    public function read(int $n): string
    {
        if ($n > $this->size) {
            throw new \RuntimeException('Not enough bytes to read.');
        }

        /** @psalm-var non-empty-string $buf */
        $buf = substr($this->bytes, 0, $n);
        $this->bytes = substr($this->bytes, $n);
        $this->size -= $n;

        return $buf;
    }

    public function write(string $bytes): void
    {
        $this->bytes .= $bytes;
        $this->size += strlen($bytes);
    }

    public function __toString(): string
    {
        return $this->bytes;
    }

    /**
     * @return int<0, max>
     */
    public function count(): int
    {
        return $this->size;
    }
}
