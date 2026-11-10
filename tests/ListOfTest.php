<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ListOfTest extends TestCase
{
    #[Test]
    public function describe_returns_list_notation(): void
    {
        $type = new ListOf(Scalar::Int);

        $this->assertSame('list<int>', $type->describe());
    }

    #[Test]
    public function accepts_empty_list(): void
    {
        $type = new ListOf(Scalar::Int);

        $this->assertSame(true, $type->accepts([]));
    }

    #[Test]
    public function accepts_list_of_matching_items(): void
    {
        $type = new ListOf(Scalar::Int);

        $this->assertSame(true, $type->accepts([1, 2, 3]));
    }

    #[Test]
    public function rejects_non_array_values(): void
    {
        $type = new ListOf(Scalar::Int);

        $this->assertSame(false, $type->accepts('string'));
        $this->assertSame(false, $type->accepts(1));
    }

    #[Test]
    public function rejects_arrays_that_are_not_lists(): void
    {
        $type = new ListOf(Scalar::Int);

        $this->assertSame(false, $type->accepts([1 => 'a']));
        $this->assertSame(false, $type->accepts(['a' => 1]));
    }

    #[Test]
    public function rejects_list_with_item_of_mismatched_type(): void
    {
        $type = new ListOf(Scalar::Int);

        $this->assertSame(false, $type->accepts([1, 'a']));
    }
}
