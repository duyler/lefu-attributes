<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class VisibleAsTest extends TestCase
{
    #[Test]
    public function flags_match_target_property_method_and_constant_mask(): void
    {
        $instance = new ReflectionClass(VisibleAs::class)->getAttributes(Attribute::class)[0]->newInstance();

        $this->assertSame(
            Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT,
            $instance->flags,
        );
    }

    #[Test]
    public function attribute_on_property_exposes_promoted_visibility(): void
    {
        $reflection = new ReflectionProperty(VisibleAsPropertyFixture::class, 'value');
        $instance = $reflection->getAttributes(VisibleAs::class)[0]->newInstance();

        $this->assertInstanceOf(VisibleAs::class, $instance);
        $this->assertSame(Visibility::Public, $instance->visibility);
    }

    #[Test]
    public function attribute_on_method_exposes_promoted_visibility(): void
    {
        $reflection = new ReflectionMethod(VisibleAsMethodFixture::class, 'handle');
        $instance = $reflection->getAttributes(VisibleAs::class)[0]->newInstance();

        $this->assertInstanceOf(VisibleAs::class, $instance);
        $this->assertSame(Visibility::Public, $instance->visibility);
    }

    #[Test]
    public function attribute_on_constant_exposes_promoted_visibility(): void
    {
        $reflection = new ReflectionClassConstant(VisibleAsConstantFixture::class, 'NAME');
        $instance = $reflection->getAttributes(VisibleAs::class)[0]->newInstance();

        $this->assertInstanceOf(VisibleAs::class, $instance);
        $this->assertSame(Visibility::Public, $instance->visibility);
    }

    #[Test]
    public function attribute_on_parameter_target_throws_error_on_new_instance(): void
    {
        $attributes = new ReflectionMethod(VisibleAsParameterFixture::class, 'handle')
            ->getParameters()[0]
            ->getAttributes(VisibleAs::class);

        $this->expectException(Error::class);

        $attributes[0]->newInstance();
    }
}

final class VisibleAsPropertyFixture
{
    #[VisibleAs(Visibility::Public)]
    public int $value = 0;
}

final class VisibleAsMethodFixture
{
    #[VisibleAs(Visibility::Public)]
    public function handle(): void {}
}

final class VisibleAsConstantFixture
{
    #[VisibleAs(Visibility::Public)]
    public const string NAME = 'x';
}

final class VisibleAsParameterFixture
{
    public function handle(#[VisibleAs(Visibility::Public)] int $value): void {}
}
