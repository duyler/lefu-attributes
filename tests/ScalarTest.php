<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ScalarTest extends TestCase
{
    #[Test]
    #[DataProvider('provide_cases')]
    public function describe_returns_backed_value_for_each_case(Scalar $case, string $expected): void
    {
        $this->assertSame($expected, $case->describe());
    }

    #[Test]
    #[DataProvider('provide_accepts_cases')]
    public function accepts_only_values_of_the_matching_php_type(Scalar $case, mixed $value, bool $expected): void
    {
        $this->assertSame($expected, $case->accepts($value));
    }

    public static function provide_cases(): array
    {
        return [
            'int' => [Scalar::Int, 'int'],
            'string' => [Scalar::String, 'string'],
            'bool' => [Scalar::Bool, 'bool'],
            'float' => [Scalar::Float, 'float'],
            'null' => [Scalar::Null, 'null'],
        ];
    }

    public static function provide_accepts_cases(): array
    {
        return [
            'int accepts int' => [Scalar::Int, 1, true],
            'int rejects float without widening' => [Scalar::Int, 1.0, false],
            'string accepts string' => [Scalar::String, 'x', true],
            'string rejects int' => [Scalar::String, 1, false],
            'bool accepts bool' => [Scalar::Bool, true, true],
            'bool rejects int' => [Scalar::Bool, 1, false],
            'float accepts float' => [Scalar::Float, 1.5, true],
            'float rejects int without widening' => [Scalar::Float, 1, false],
            'null accepts null' => [Scalar::Null, null, true],
            'null rejects zero' => [Scalar::Null, 0, false],
        ];
    }
}
