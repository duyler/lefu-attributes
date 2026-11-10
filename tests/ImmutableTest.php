<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ImmutableTest extends TestCase
{
    #[Test]
    public function flags_match_target_property_and_class_mask(): void
    {
        $instance = new ReflectionClass(Immutable::class)->getAttributes(Attribute::class)[0]->newInstance();

        $this->assertSame(Attribute::TARGET_PROPERTY | Attribute::TARGET_CLASS, $instance->flags);
    }

    #[Test]
    public function attribute_on_class_instantiates_immutable(): void
    {
        $reflection = new ReflectionClass(ImmutableClassFixture::class);
        $instance = $reflection->getAttributes(Immutable::class)[0]->newInstance();

        $this->assertInstanceOf(Immutable::class, $instance);
    }

    #[Test]
    public function attribute_on_property_instantiates_immutable(): void
    {
        $reflection = new ReflectionProperty(ImmutablePropertyFixture::class, 'value');
        $instance = $reflection->getAttributes(Immutable::class)[0]->newInstance();

        $this->assertInstanceOf(Immutable::class, $instance);
    }

    #[Test]
    public function attribute_on_method_target_throws_error_on_new_instance(): void
    {
        $attributes = new ReflectionMethod(ImmutableMethodFixture::class, 'handle')->getAttributes(Immutable::class);

        $this->expectException(Error::class);

        $attributes[0]->newInstance();
    }
}

#[Immutable]
final class ImmutableClassFixture {}

final class ImmutablePropertyFixture
{
    #[Immutable]
    public int $value = 0;
}

final class ImmutableMethodFixture
{
    #[Immutable]
    public function handle(): void {}
}
