<?php

declare(strict_types=1);

final readonly class Map implements Type
{
    public function __construct(
        public Type $key,
        public Type $value,
    ) {}

    #[Override]
    public function describe(): string
    {
        return "array<{$this->key->describe()}, {$this->value->describe()}>";
    }

    #[Override]
    public function accepts(mixed $value): bool
    {
        if (!\is_array($value)) {
            return false;
        }
        return array_all($value, fn($v, $k) => $this->key->accepts($k) && $this->value->accepts($v));
    }
}
