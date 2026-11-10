<?php

declare(strict_types=1);

interface Comparable
{
    public function compareTo(mixed $other): int;
}
