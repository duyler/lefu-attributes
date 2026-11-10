<?php

declare(strict_types=1);

enum Special: string implements Type
{
    case Any    = 'Any';
    case Object = 'object';
    case Array  = 'array';

    #[Override]
    public function describe(): string
    {
        return $this->value;
    }

    #[Override]
    public function accepts(mixed $value): bool
    {
        return match ($this) {
            self::Any    => true,
            self::Object => \is_object($value),
            self::Array  => \is_array($value),
        };
    }
}
