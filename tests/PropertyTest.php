<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PropertyTest extends TestCase
{
    #[Test]
    public function flags_match_target_property_mask(): void
    {
        $instance = new ReflectionClass(Property::class)->getAttributes(Attribute::class)[0]->newInstance();

        $this->assertSame(Attribute::TARGET_PROPERTY, $instance->flags);
    }

    #[Test]
    public function attribute_on_property_exposes_promoted_type(): void
    {
        $reflection = new ReflectionProperty(PropertyFixture::class, 'value');
        $instance = $reflection->getAttributes(Property::class)[0]->newInstance();

        $this->assertInstanceOf(Property::class, $instance);
        $this->assertSame(Scalar::Int, $instance->type);
    }

    #[Test]
    public function attribute_on_method_target_throws_error_on_new_instance(): void
    {
        $attributes = new ReflectionMethod(PropertyMethodFixture::class, 'handle')->getAttributes(Property::class);

        $this->expectException(Error::class);

        $attributes[0]->newInstance();
    }
}

final class PropertyFixture
{
    #[Property(Scalar::Int)]
    public int $value = 0;
}

final class PropertyMethodFixture
{
    #[Property(Scalar::Int)]
    public function handle(): void {}
}
