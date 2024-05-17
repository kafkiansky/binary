<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

/**
 * @api
 */
interface WriteBytes
{
    public function write(string $bytes): self;
}
