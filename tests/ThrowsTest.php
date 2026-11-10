<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ThrowsTest extends TestCase
{
    #[Test]
    public function flags_match_target_method_and_function_mask(): void
    {
        $instance = new ReflectionClass(Throws::class)->getAttributes(Attribute::class)[0]->newInstance();

        $this->assertSame(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION, $instance->flags);
    }

    #[Test]
    public function attribute_on_method_exposes_promoted_object_of_payload(): void
    {
        $reflection = new ReflectionMethod(ThrowsMethodFixture::class, 'handle');
        $instance = $reflection->getAttributes(Throws::class)[0]->newInstance();

        $this->assertInstanceOf(Throws::class, $instance);
        $this->assertInstanceOf(ObjectOf::class, $instance->exception);
        $this->assertSame(ThrowsPayloadFixture::class, $instance->exception->className);
    }

    #[Test]
    public function attribute_on_function_exposes_promoted_object_of_payload(): void
    {
        $reflection = new ReflectionFunction('ThrowsFunctionFixture');
        $instance = $reflection->getAttributes(Throws::class)[0]->newInstance();

        $this->assertInstanceOf(Throws::class, $instance);
        $this->assertInstanceOf(ObjectOf::class, $instance->exception);
        $this->assertSame(ThrowsPayloadFixture::class, $instance->exception->className);
    }

    #[Test]
    public function attribute_on_property_target_throws_error_on_new_instance(): void
    {
        $attributes = new ReflectionProperty(ThrowsPropertyFixture::class, 'value')->getAttributes(Throws::class);

        $this->expectException(Error::class);

        $attributes[0]->newInstance();
    }
}

final class ThrowsPayloadFixture implements ThrowablePayload {}

final class ThrowsMethodFixture
{
    #[Throws(new ObjectOf(ThrowsPayloadFixture::class))]
    public function handle(): void {}
}

#[Throws(new ObjectOf(ThrowsPayloadFixture::class))]
function ThrowsFunctionFixture(): void {}

final class ThrowsPropertyFixture
{
    #[Throws(new ObjectOf(ThrowsPayloadFixture::class))]
    public int $value = 0;
}
