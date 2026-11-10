<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class TypesTest extends TestCase
{
    #[Test]
    public function matches_delegates_accepts_for_scalar_type(): void
    {
        $this->assertSame(true, Types::matches(1, Scalar::Int));
        $this->assertSame(false, Types::matches('x', Scalar::Int));
    }

    #[Test]
    public function matches_delegates_accepts_for_object_type(): void
    {
        $this->assertSame(true, Types::matches(new stdClass(), new ObjectOf('stdClass')));
        $this->assertSame(false, Types::matches(1, new ObjectOf('stdClass')));
    }
}
