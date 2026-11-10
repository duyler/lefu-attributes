<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UnionTest extends TestCase
{
    #[Test]
    public function constructor_with_zero_types_throws_invalid_argument_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Union must have at least 2 types');

        new Union();
    }

    #[Test]
    public function constructor_with_one_type_throws_invalid_argument_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Union must have at least 2 types');

        new Union(Scalar::Int);
    }

    #[Test]
    public function describe_returns_pipe_separated_type_names(): void
    {
        $type = new Union(Scalar::Int, Scalar::Null);

        $this->assertSame('int|null', $type->describe());
    }

    #[Test]
    public function describe_returns_pipe_separated_type_names_for_three_types(): void
    {
        $type = new Union(Scalar::Int, Scalar::String, Scalar::Null);

        $this->assertSame('int|string|null', $type->describe());
    }

    #[Test]
    public function accepts_value_matching_first_branch(): void
    {
        $type = new Union(Scalar::Int, Scalar::Null);

        $this->assertSame(true, $type->accepts(1));
    }

    #[Test]
    public function accepts_null_matching_second_branch(): void
    {
        $type = new Union(Scalar::Int, Scalar::Null);

        $this->assertSame(true, $type->accepts(null));
    }

    #[Test]
    public function rejects_value_matching_no_branch(): void
    {
        $type = new Union(Scalar::Int, Scalar::Null);

        $this->assertSame(false, $type->accepts('x'));
    }
}
