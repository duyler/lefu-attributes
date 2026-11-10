<?php

declare(strict_types=1);

#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class Parameter
{
    public function __construct(
        public string $name,
        public Type $type,
    ) {}
}
