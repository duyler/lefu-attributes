<?php

declare(strict_types=1);

enum Scalar: string implements Type
{
    case Int    = 'int';
    case String = 'string';
    case Bool   = 'bool';
    case Float  = 'float';
    case Null   = 'null';

    #[Override]
    public function describe(): string
    {
        return $this->value;
    }

    #[Override]
    public function accepts(mixed $value): bool
    {
        return match ($this) {
            self::Int    => \is_int($value),
            self::String => \is_string($value),
            self::Bool   => \is_bool($value),
            self::Float  => \is_float($value),
            self::Null   => $value === null,
        };
    }
}
