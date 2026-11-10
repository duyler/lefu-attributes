<?php

declare(strict_types=1);

final readonly class ListOf implements Type
{
    public function __construct(public Type $item) {}

    #[Override]
    public function describe(): string
    {
        return "list<{$this->item->describe()}>";
    }

    #[Override]
    public function accepts(mixed $value): bool
    {
        if (!\is_array($value) || !array_is_list($value)) {
            return false;
        }
        return array_all($value, fn($item) => $this->item->accepts($item));
    }
}
