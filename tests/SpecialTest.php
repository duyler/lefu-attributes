<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SpecialTest extends TestCase
{
    #[Test]
    #[DataProvider('provide_cases')]
    public function describe_returns_backed_value_for_each_case(Special $case, string $expected): void
    {
        $this->assertSame($expected, $case->describe());
    }

    #[Test]
    public function any_accepts_any_value(): void
    {
        $type = Special::Any;

        $this->assertSame(true, $type->accepts(1));
        $this->assertSame(true, $type->accepts('x'));
        $this->assertSame(true, $type->accepts(null));
        $this->assertSame(true, $type->accepts([1]));
        $this->assertSame(true, $type->accepts(new stdClass()));
    }

    #[Test]
    public function object_accepts_objects_and_rejects_non_objects(): void
    {
        $type = Special::Object;

        $this->assertSame(true, $type->accepts(new stdClass()));
        $this->assertSame(false, $type->accepts(1));
    }

    #[Test]
    public function array_accepts_arrays_and_rejects_non_arrays(): void
    {
        $type = Special::Array;

        $this->assertSame(true, $type->accepts([1]));
        $this->assertSame(false, $type->accepts('x'));
    }

    public static function provide_cases(): array
    {
        return [
            'Any' => [Special::Any, 'Any'],
            'object' => [Special::Object, 'object'],
            'array' => [Special::Array, 'array'],
        ];
    }
}
