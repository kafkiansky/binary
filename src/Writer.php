<?php

declare(strict_types=1);

namespace Kafkiansky\Binary;

/**
 * @api
 */
interface Writer
{
    public function write(string $bytes): self;
}
