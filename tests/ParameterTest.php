<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ParameterTest extends TestCase
{
    #[Test]
    public function flags_match_target_parameter_mask(): void
    {
        $instance = new ReflectionClass(Parameter::class)->getAttributes(Attribute::class)[0]->newInstance();

        $this->assertSame(Attribute::TARGET_PARAMETER, $instance->flags);
    }

    #[Test]
    public function attribute_on_parameter_exposes_promoted_name_and_type(): void
    {
        $parameter = new ReflectionMethod(ParameterFixture::class, 'handle')->getParameters()[0];
        $instance = $parameter->getAttributes(Parameter::class)[0]->newInstance();

        $this->assertInstanceOf(Parameter::class, $instance);
        $this->assertSame('value', $instance->name);
        $this->assertSame(Scalar::Int, $instance->type);
    }

    #[Test]
    public function attribute_on_property_target_throws_error_on_new_instance(): void
    {
        $attributes = new ReflectionProperty(ParameterPropertyFixture::class, 'value')->getAttributes(Parameter::class);

        $this->expectException(Error::class);

        $attributes[0]->newInstance();
    }
}

final class ParameterFixture
{
    public function handle(#[Parameter('value', Scalar::Int)] int $value): void {}
}

final class ParameterPropertyFixture
{
    #[Parameter('value', Scalar::Int)]
    public int $value = 0;
}
