<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ContractsTest extends TestCase
{
    #[Test]
    public function equals_returns_true_for_equal_values(): void
    {
        $equatable = new EquatableFixture();

        $this->assertSame(true, $equatable->equals(new EquatableFixture()));
    }

    #[Test]
    public function equals_returns_false_for_different_values_and_foreign_objects(): void
    {
        $equatable = new EquatableFixture();
        $other = new EquatableFixture();
        $other->value = 2;

        $this->assertSame(false, $equatable->equals($other));
        $this->assertSame(false, $equatable->equals(new stdClass()));
    }

    #[Test]
    public function hash_code_returns_deterministic_int(): void
    {
        $hashable = new HashableFixture();

        $this->assertSame(42, $hashable->hashCode());
        $this->assertSame(42, new HashableFixture()->hashCode());
    }

    #[Test]
    public function compare_to_returns_zero_for_any_other(): void
    {
        $comparable = new ComparableFixture();

        $this->assertSame(0, $comparable->compareTo(new ComparableFixture()));
        $this->assertSame(0, $comparable->compareTo(new stdClass()));
    }

    #[Test]
    public function types_matches_accepts_contract_implementations(): void
    {
        $this->assertSame(true, Types::matches(new EquatableFixture(), new ObjectOf(Equatable::class)));
        $this->assertSame(true, Types::matches(new HashableFixture(), new ObjectOf(Hashable::class)));
        $this->assertSame(true, Types::matches(new ComparableFixture(), new ObjectOf(Comparable::class)));
    }

    #[Test]
    public function types_matches_rejects_foreign_objects(): void
    {
        $foreign = new stdClass();

        $this->assertSame(false, Types::matches($foreign, new ObjectOf(Equatable::class)));
        $this->assertSame(false, Types::matches($foreign, new ObjectOf(Hashable::class)));
        $this->assertSame(false, Types::matches($foreign, new ObjectOf(Comparable::class)));
    }

    #[Test]
    public function contract_interfaces_declare_wide_parameter_types(): void
    {
        $equals = new ReflectionMethod(Equatable::class, 'equals')->getParameters()[0]->getType();
        $compareTo = new ReflectionMethod(Comparable::class, 'compareTo')->getParameters()[0]->getType();

        $this->assertInstanceOf(ReflectionNamedType::class, $equals);
        $this->assertSame('mixed', $equals->getName());
        $this->assertInstanceOf(ReflectionNamedType::class, $compareTo);
        $this->assertSame('mixed', $compareTo->getName());
        $this->assertSame([], new ReflectionMethod(Hashable::class, 'hashCode')->getParameters());
    }
}

final class EquatableFixture implements Equatable
{
    public int $value = 1;

    public function equals(mixed $other): bool
    {
        return $other instanceof self && $other->value === $this->value;
    }
}

final class HashableFixture implements Hashable
{
    public function hashCode(): int
    {
        return 42;
    }
}

final class ComparableFixture implements Comparable
{
    public function compareTo(mixed $other): int
    {
        return 0;
    }
}
