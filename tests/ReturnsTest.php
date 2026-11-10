<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ReturnsTest extends TestCase
{
    #[Test]
    public function flags_match_target_method_and_function_mask(): void
    {
        $instance = new ReflectionClass(Returns::class)->getAttributes(Attribute::class)[0]->newInstance();

        $this->assertSame(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION, $instance->flags);
    }

    #[Test]
    public function attribute_on_method_exposes_promoted_type(): void
    {
        $reflection = new ReflectionMethod(ReturnsMethodFixture::class, 'handle');
        $instance = $reflection->getAttributes(Returns::class)[0]->newInstance();

        $this->assertInstanceOf(Returns::class, $instance);
        $this->assertSame(Scalar::String, $instance->type);
    }

    #[Test]
    public function attribute_on_function_exposes_promoted_type(): void
    {
        $reflection = new ReflectionFunction('ReturnsFunctionFixture');
        $instance = $reflection->getAttributes(Returns::class)[0]->newInstance();

        $this->assertInstanceOf(Returns::class, $instance);
        $this->assertSame(Scalar::String, $instance->type);
    }

    #[Test]
    public function attribute_on_property_target_throws_error_on_new_instance(): void
    {
        $attributes = new ReflectionProperty(ReturnsPropertyFixture::class, 'value')->getAttributes(Returns::class);

        $this->expectException(Error::class);

        $attributes[0]->newInstance();
    }
}

final class ReturnsMethodFixture
{
    #[Returns(Scalar::String)]
    public function handle(): void {}
}

#[Returns(Scalar::String)]
function ReturnsFunctionFixture(): void {}

final class ReturnsPropertyFixture
{
    #[Returns(Scalar::String)]
    public int $value = 0;
}
