<?php

declare(strict_types=1);

final readonly class Union implements Type
{
    /** @var Type[] */
    public array $types;

    public function __construct(Type ...$types)
    {
        if (\count($types) < 2) {
            throw new InvalidArgumentException(
                'Union must have at least 2 types',
            );
        }
        $this->types = $types;
    }

    #[Override]
    public function describe(): string
    {
        return implode('|', array_map(
            static fn(Type $t): string => $t->describe(),
            $this->types,
        ));
    }

    #[Override]
    public function accepts(mixed $value): bool
    {
        return array_any($this->types, fn($type) => $type->accepts($value));
    }
}
