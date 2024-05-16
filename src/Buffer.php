<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

use Psl\Type;

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

    /**
     * @param non-empty-string $bytes
     */
    public static function fromString(string $bytes, ?Endianness $endianness = null): self
    {
        return new self($bytes, $endianness);
    }

    public function writeInt8(int $value): self
    {
        $this->endianness->writeInt8($this, Type\i8()->assert($value));

        return $this;
    }

    public function writeUint8(int $value): self
    {
        $this->endianness->writeUint8($this, Type\u8()->assert($value));

        return $this;
    }

    public function writeInt16(int $value): self
    {
        $this->endianness->writeInt16($this, Type\i16()->assert($value));

        return $this;
    }

    public function writeUint16(int $value): self
    {
        $this->endianness->writeUint16($this, Type\u16()->assert($value));

        return $this;
    }

    public function writeInt32(int $value): self
    {
        $this->endianness->writeInt32($this, Type\i32()->assert($value));

        return $this;
    }

    public function writeUint32(int $value): self
    {
        $this->endianness->writeUint32($this, Type\u32()->assert($value));

        return $this;
    }

    public function writeInt64(int $value): self
    {
        $this->endianness->writeInt64($this, $value);

        return $this;
    }

    public function writeUint64(int $value): self
    {
        $this->endianness->writeUint64($this, Type\uint()->assert($value));

        return $this;
    }

    final public function writeVarInt(int $number): self
    {
        $zigZagNumber = $number << 1;
        if ($number < 0) {
            $zigZagNumber = ~$zigZagNumber;
        }

        return $this->writeVarUint($zigZagNumber);
    }

    final public function writeVarUint(int $number): self
    {
        $bytes = [];

        do {
            $byte = $number & 127;
            $number >>= 7;
            if ($number > 0) {
                $byte |= 128;
            }
            $bytes[] = $byte;
        } while ($number > 0);

        $this->write(namespace\pack('C*', $bytes));

        return $this;
    }

    public function writeFloat(float $value): self
    {
        $this->endianness->writeFloat($this, $value);

        return $this;
    }

    public function writeDouble(float $value): self
    {
        $this->endianness->writeDouble($this, $value);

        return $this;
    }

    /**
     * @throws BinaryException
     */
    public function readInt8(): int
    {
        return $this->endianness->readInt8($this);
    }

    /**
     * @throws BinaryException
     */
    public function readUint8(): int
    {
        return $this->endianness->readUint8($this);
    }

    /**
     * @throws BinaryException
     */
    public function readInt16(): int
    {
        return $this->endianness->readInt16($this);
    }

    /**
     * @throws BinaryException
     */
    public function readUint16(): int
    {
        return $this->endianness->readUint16($this);
    }

    /**
     * @throws BinaryException
     */
    public function readInt32(): int
    {
        return $this->endianness->readInt32($this);
    }

    /**
     * @throws BinaryException
     */
    public function readUint32(): int
    {
        return $this->endianness->readUint32($this);
    }

    /**
     * @throws BinaryException
     */
    public function readInt64(): int
    {
        return $this->endianness->readInt64($this);
    }

    /**
     * @throws BinaryException
     */
    public function readUint64(): int
    {
        return $this->endianness->readUint64($this);
    }

    /**
     * @throws BinaryException
     */
    final public function readVarInt(): int
    {
        $zigZagNumber = $this->readVarUint();

        $number = $zigZagNumber >> 1;

        if ($zigZagNumber & 1) {
            $number = ~$number;
        }

        return $number;
    }

    /**
     * @throws BinaryException
     */
    final public function readVarUint(): int
    {
        $number = $shift = $bytesRead = 0;

        foreach (str_split($this->bytes) as $byte) {
            $number |= (ord($byte) & 127) << $shift;
            $shift += 7;
            $bytesRead++;
            if (!(ord($byte) & 128)) {
                break;
            }
        }

        if (0 < $bytesRead) {
            $this->read($bytesRead);
        }

        return $number;
    }

    /**
     * @throws BinaryException
     */
    public function readFloat(): float
    {
        return $this->endianness->readFloat($this);
    }

    /**
     * @throws BinaryException
     */
    public function readDouble(): float
    {
        return $this->endianness->readDouble($this);
    }

    public function reset(): string
    {
        [$bytes, $this->bytes, $this->size] = [$this->bytes, '', 0];

        return $bytes;
    }

    /**
     * {@inheritdoc}
     */
    public function read(int $n): string
    {
        if ($n > $this->size) {
            throw BinaryException::whenNotEnoughBytesToRead($n, $this->size);
        }

        /** @psalm-var non-empty-string $buf */
        $buf = substr($this->bytes, 0, $n);
        $this->bytes = substr($this->bytes, $n);
        /** @psalm-suppress InvalidPropertyAssignmentValue No errors here. */
        $this->size -= $n;

        return $buf;
    }

    public function write(string $bytes): self
    {
        $this->bytes .= $bytes;
        $this->size += strlen($bytes);

        return $this;
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
