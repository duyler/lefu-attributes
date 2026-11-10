<?php

declare(strict_types=1);

final class Types
{
    public static function matches(mixed $value, Type $type): bool
    {
        return $type->accepts($value);
    }
}
