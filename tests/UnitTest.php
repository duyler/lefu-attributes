<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UnitTest extends TestCase
{
    #[Test]
    public function flags_match_target_method_and_function_mask(): void
    {
        $instance = new ReflectionClass(Unit::class)->getAttributes(Attribute::class)[0]->newInstance();

        $this->assertSame(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION, $instance->flags);
    }

    #[Test]
    public function attribute_on_method_instantiates_unit(): void
    {
        $reflection = new ReflectionMethod(UnitMethodFixture::class, 'handle');
        $instance = $reflection->getAttributes(Unit::class)[0]->newInstance();

        $this->assertInstanceOf(Unit::class, $instance);
    }

    #[Test]
    public function attribute_on_function_instantiates_unit(): void
    {
        $reflection = new ReflectionFunction('UnitFunctionFixture');
        $instance = $reflection->getAttributes(Unit::class)[0]->newInstance();

        $this->assertInstanceOf(Unit::class, $instance);
    }

    #[Test]
    public function attribute_on_property_target_throws_error_on_new_instance(): void
    {
        $attributes = new ReflectionProperty(UnitPropertyFixture::class, 'value')->getAttributes(Unit::class);

        $this->expectException(Error::class);

        $attributes[0]->newInstance();
    }
}

final class UnitMethodFixture
{
    #[Unit]
    public function handle(): void {}
}

#[Unit]
function UnitFunctionFixture(): void {}

final class UnitPropertyFixture
{
    #[Unit]
    public int $value = 0;
}
