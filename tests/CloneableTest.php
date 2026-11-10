<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CloneableTest extends TestCase
{
    #[Test]
    public function flags_match_target_class_mask(): void
    {
        $instance = new ReflectionClass(Cloneable::class)->getAttributes(Attribute::class)[0]->newInstance();

        $this->assertSame(Attribute::TARGET_CLASS, $instance->flags);
    }

    #[Test]
    public function attribute_on_class_instantiates_cloneable(): void
    {
        $reflection = new ReflectionClass(CloneableClassFixture::class);
        $instance = $reflection->getAttributes(Cloneable::class)[0]->newInstance();

        $this->assertInstanceOf(Cloneable::class, $instance);
    }

    #[Test]
    public function attribute_on_property_target_throws_error_on_new_instance(): void
    {
        $attributes = new ReflectionProperty(CloneablePropertyFixture::class, 'value')->getAttributes(Cloneable::class);

        $this->expectException(Error::class);

        $attributes[0]->newInstance();
    }
}

#[Cloneable]
final class CloneableClassFixture {}

final class CloneablePropertyFixture
{
    #[Cloneable]
    public int $value = 0;
}
