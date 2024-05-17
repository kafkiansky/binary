<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

/**
 * @api
 */
interface ConsumeBytes
{
    /**
     * @param positive-int $n
     *
     * @throws BinaryException
     *
     * @return non-empty-string
     */
    public function consume(int $n): string;
}
