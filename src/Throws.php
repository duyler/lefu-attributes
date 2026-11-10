<?php

declare(strict_types=1);

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
final readonly class Throws
{
    public function __construct(public ObjectOf $exception) {}
}
