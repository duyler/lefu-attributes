<?php

declare(strict_types=1);

final readonly class ObjectOf implements Type
{
    public function __construct(public string $className) {}

    #[Override]
    public function describe(): string
    {
        return $this->className;
    }

    #[Override]
    public function accepts(mixed $value): bool
    {
        return $value instanceof $this->className;
    }
}
