<?php

declare(strict_types=1);

interface Equatable
{
    public function equals(mixed $other): bool;
}
