<?php

declare(strict_types=1);

interface Type
{
    public function describe(): string;

    public function accepts(mixed $value): bool;
}
