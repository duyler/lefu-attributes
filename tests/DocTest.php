<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class DocTest extends TestCase
{
    #[Test]
    public function flags_match_target_class_method_function_property_and_constant_mask(): void
    {
        $instance = new ReflectionClass(Doc::class)->getAttributes(Attribute::class)[0]->newInstance();

        $this->assertSame(
            Attribute::TARGET_CLASS
            | Attribute::TARGET_METHOD
            | Attribute::TARGET_FUNCTION
            | Attribute::TARGET_PROPERTY
            | Attribute::TARGET_CLASS_CONSTANT,
            $instance->flags,
        );
    }

    #[Test]
    public function attribute_on_class_exposes_promoted_text(): void
    {
        $reflection = new ReflectionClass(DocClassFixture::class);
        $instance = $reflection->getAttributes(Doc::class)[0]->newInstance();

        $this->assertInstanceOf(Doc::class, $instance);
        $this->assertSame('example', $instance->text);
    }

    #[Test]
    public function attribute_on_method_exposes_promoted_text(): void
    {
        $reflection = new ReflectionMethod(DocMethodFixture::class, 'handle');
        $instance = $reflection->getAttributes(Doc::class)[0]->newInstance();

        $this->assertInstanceOf(Doc::class, $instance);
        $this->assertSame('example', $instance->text);
    }

    #[Test]
    public function attribute_on_function_exposes_promoted_text(): void
    {
        $reflection = new ReflectionFunction('DocFunctionFixture');
        $instance = $reflection->getAttributes(Doc::class)[0]->newInstance();

        $this->assertInstanceOf(Doc::class, $instance);
        $this->assertSame('example', $instance->text);
    }

    #[Test]
    public function attribute_on_property_exposes_promoted_text(): void
    {
        $reflection = new ReflectionProperty(DocPropertyFixture::class, 'value');
        $instance = $reflection->getAttributes(Doc::class)[0]->newInstance();

        $this->assertInstanceOf(Doc::class, $instance);
        $this->assertSame('example', $instance->text);
    }

    #[Test]
    public function attribute_on_constant_exposes_promoted_text(): void
    {
        $reflection = new ReflectionClassConstant(DocConstantFixture::class, 'NAME');
        $instance = $reflection->getAttributes(Doc::class)[0]->newInstance();

        $this->assertInstanceOf(Doc::class, $instance);
        $this->assertSame('example', $instance->text);
    }

    #[Test]
    public function attribute_on_parameter_target_throws_error_on_new_instance(): void
    {
        $attributes = new ReflectionMethod(DocParameterFixture::class, 'handle')
            ->getParameters()[0]
            ->getAttributes(Doc::class);

        $this->expectException(Error::class);

        $attributes[0]->newInstance();
    }
}

#[Doc('example')]
final class DocClassFixture {}

final class DocMethodFixture
{
    #[Doc('example')]
    public function handle(): void {}
}

#[Doc('example')]
function DocFunctionFixture(): void {}

final class DocPropertyFixture
{
    #[Doc('example')]
    public int $value = 0;
}

final class DocConstantFixture
{
    #[Doc('example')]
    public const string NAME = 'x';
}

final class DocParameterFixture
{
    public function handle(#[Doc('example')] int $value): void {}
}
