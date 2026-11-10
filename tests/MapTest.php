<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MapTest extends TestCase
{
    #[Test]
    public function describe_returns_array_notation(): void
    {
        $type = new Map(Scalar::Int, Scalar::String);

        $this->assertSame('array<int, string>', $type->describe());
    }

    #[Test]
    public function accepts_list_with_int_keys(): void
    {
        $type = new Map(Scalar::Int, Scalar::String);

        $this->assertSame(true, $type->accepts([0 => 'a', 1 => 'b']));
    }

    #[Test]
    public function accepts_string_keys_when_key_type_matches(): void
    {
        $type = new Map(Scalar::String, Scalar::Int);

        $this->assertSame(true, $type->accepts(['a' => 1]));
    }

    #[Test]
    public function accepts_empty_array(): void
    {
        $type = new Map(Scalar::Int, Scalar::String);

        $this->assertSame(true, $type->accepts([]));
    }

    #[Test]
    public function rejects_entry_with_wrong_key(): void
    {
        $type = new Map(Scalar::Int, Scalar::String);

        $this->assertSame(false, $type->accepts(['a' => 'x']));
    }

    #[Test]
    public function rejects_entry_with_wrong_value(): void
    {
        $type = new Map(Scalar::Int, Scalar::String);

        $this->assertSame(false, $type->accepts([0 => 1]));
    }

    #[Test]
    public function rejects_non_array_values(): void
    {
        $type = new Map(Scalar::Int, Scalar::String);

        $this->assertSame(false, $type->accepts('string'));
    }
}
