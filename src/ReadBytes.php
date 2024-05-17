<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

/**
 * @api
 */
interface ReadBytes
{
    /**
     * @param positive-int $n
     *
     * @throws BinaryException
     *
     * @return non-empty-string
     */
    public function read(int $n): string;
}
