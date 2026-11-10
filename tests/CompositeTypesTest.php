<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CompositeTypesTest extends TestCase
{
    #[Test]
    public function nested_list_of_map_describe_is_recursive(): void
    {
        $type = new ListOf(new Map(Scalar::Int, Scalar::String));

        $this->assertSame('list<array<int, string>>', $type->describe());
    }

    #[Test]
    public function nested_list_of_map_accepts_items_matching_inner_map(): void
    {
        $type = new ListOf(new Map(Scalar::Int, Scalar::String));

        $this->assertSame(true, $type->accepts([]));
        $this->assertSame(true, $type->accepts([[0 => 'a'], [1 => 'b']]));
        $this->assertSame(false, $type->accepts([[0 => 1]]));
        $this->assertSame(false, $type->accepts([['a' => 'x']]));
        $this->assertSame(false, $type->accepts(['x']));
        $this->assertSame(false, $type->accepts([1 => [0 => 'a']]));
    }

    #[Test]
    public function nested_union_of_list_and_null_describe_is_recursive(): void
    {
        $type = new Union(new ListOf(Scalar::Int), Scalar::Null);

        $this->assertSame('list<int>|null', $type->describe());
    }

    #[Test]
    public function nested_union_of_list_and_null_accepts_and_rejects_branches(): void
    {
        $type = new Union(new ListOf(Scalar::Int), Scalar::Null);

        $this->assertSame(true, $type->accepts([]));
        $this->assertSame(true, $type->accepts([1, 2]));
        $this->assertSame(true, $type->accepts(null));
        $this->assertSame(false, $type->accepts([1 => 'a']));
        $this->assertSame(false, $type->accepts([1, 'a']));
        $this->assertSame(false, $type->accepts('x'));
    }

    #[Test]
    public function nested_map_of_list_describe_and_accepts_are_recursive(): void
    {
        $type = new Map(Scalar::String, new ListOf(Scalar::Int));

        $this->assertSame('array<string, list<int>>', $type->describe());
        $this->assertSame(true, $type->accepts(['a' => [1, 2]]));
        $this->assertSame(true, $type->accepts(['a' => []]));
        $this->assertSame(false, $type->accepts(['a' => [1, 'b']]));
        $this->assertSame(false, $type->accepts([0 => [1]]));
        $this->assertSame(false, $type->accepts(['a' => 'x']));
    }

    #[Test]
    public function map_with_string_keys_rejects_php_coerced_numeric_keys(): void
    {
        $stringKeys = new Map(Scalar::String, Scalar::String);
        $intKeys = new Map(Scalar::Int, Scalar::String);

        $this->assertSame(false, $stringKeys->accepts(['1' => 'a']));
        $this->assertSame(true, $intKeys->accepts(['1' => 'a']));
        $this->assertSame(false, $stringKeys->accepts(['a' => 'x', '1' => 'y']));
    }
}
