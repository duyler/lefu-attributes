<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class VariableTest extends TestCase
{
    #[Test]
    public function flags_match_target_method_and_function_mask(): void
    {
        $instance = new ReflectionClass(Variable::class)->getAttributes(Attribute::class)[0]->newInstance();

        $this->assertSame(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION, $instance->flags);
    }

    #[Test]
    public function attribute_on_method_exposes_promoted_name_and_type(): void
    {
        $reflection = new ReflectionMethod(VariableMethodFixture::class, 'handle');
        $instance = $reflection->getAttributes(Variable::class)[0]->newInstance();

        $this->assertInstanceOf(Variable::class, $instance);
        $this->assertSame('count', $instance->name);
        $this->assertSame(Scalar::Int, $instance->type);
    }

    #[Test]
    public function attribute_on_function_exposes_promoted_name_and_type(): void
    {
        $reflection = new ReflectionFunction('VariableFunctionFixture');
        $instance = $reflection->getAttributes(Variable::class)[0]->newInstance();

        $this->assertInstanceOf(Variable::class, $instance);
        $this->assertSame('count', $instance->name);
        $this->assertSame(Scalar::Int, $instance->type);
    }

    #[Test]
    public function attribute_on_property_target_throws_error_on_new_instance(): void
    {
        $attributes = new ReflectionProperty(VariablePropertyFixture::class, 'value')->getAttributes(Variable::class);

        $this->expectException(Error::class);

        $attributes[0]->newInstance();
    }
}

final class VariableMethodFixture
{
    #[Variable('count', Scalar::Int)]
    public function handle(): void {}
}

#[Variable('count', Scalar::Int)]
function VariableFunctionFixture(): void {}

final class VariablePropertyFixture
{
    #[Variable('count', Scalar::Int)]
    public int $value = 0;
}
