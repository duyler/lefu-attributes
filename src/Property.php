<?php

declare(strict_types=1);

#[Attribute(Attribute::TARGET_PROPERTY)]
final readonly class Property
{
    public function __construct(public Type $type) {}
}
