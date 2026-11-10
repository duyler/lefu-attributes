<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class NothingTest extends TestCase
{
    #[Test]
    public function flags_match_target_method_and_function_mask(): void
    {
        $instance = new ReflectionClass(Nothing::class)->getAttributes(Attribute::class)[0]->newInstance();

        $this->assertSame(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION, $instance->flags);
    }

    #[Test]
    public function attribute_on_method_instantiates_nothing(): void
    {
        $reflection = new ReflectionMethod(NothingMethodFixture::class, 'handle');
        $instance = $reflection->getAttributes(Nothing::class)[0]->newInstance();

        $this->assertInstanceOf(Nothing::class, $instance);
    }

    #[Test]
    public function attribute_on_function_instantiates_nothing(): void
    {
        $reflection = new ReflectionFunction('NothingFunctionFixture');
        $instance = $reflection->getAttributes(Nothing::class)[0]->newInstance();

        $this->assertInstanceOf(Nothing::class, $instance);
    }

    #[Test]
    public function attribute_on_property_target_throws_error_on_new_instance(): void
    {
        $attributes = new ReflectionProperty(NothingPropertyFixture::class, 'value')->getAttributes(Nothing::class);

        $this->expectException(Error::class);

        $attributes[0]->newInstance();
    }
}

final class NothingMethodFixture
{
    #[Nothing]
    public function handle(): void {}
}

#[Nothing]
function NothingFunctionFixture(): void {}

final class NothingPropertyFixture
{
    #[Nothing]
    public int $value = 0;
}
