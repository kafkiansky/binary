<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

/**
 * @api
 */
interface Reader
{
    /**
     * @param positive-int $n
     *
     * @return non-empty-string
     */
    public function read(int $n): string;
}
