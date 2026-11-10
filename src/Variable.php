<?php

declare(strict_types=1);

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
final readonly class Variable
{
    public function __construct(
        public string $name,
        public Type $type,
    ) {}
}
