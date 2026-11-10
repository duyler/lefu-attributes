<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ObjectOfTest extends TestCase
{
    #[Test]
    public function describe_returns_class_name(): void
    {
        $type = new ObjectOf(ObjectOfImplementationFixture::class);

        $this->assertSame(ObjectOfImplementationFixture::class, $type->describe());
    }

    #[Test]
    public function accepts_instance_of_its_class(): void
    {
        $type = new ObjectOf(ObjectOfImplementationFixture::class);

        $this->assertSame(true, $type->accepts(new ObjectOfImplementationFixture()));
    }

    #[Test]
    public function accepts_implementation_of_its_interface(): void
    {
        $type = new ObjectOf(ObjectOfContractFixture::class);

        $this->assertSame(true, $type->accepts(new ObjectOfImplementationFixture()));
    }

    #[Test]
    public function rejects_foreign_object(): void
    {
        $type = new ObjectOf(ObjectOfImplementationFixture::class);

        $this->assertSame(false, $type->accepts(new stdClass()));
    }

    #[Test]
    public function rejects_non_object_values(): void
    {
        $type = new ObjectOf(ObjectOfImplementationFixture::class);

        $this->assertSame(false, $type->accepts(1));
        $this->assertSame(false, $type->accepts('x'));
    }
}

interface ObjectOfContractFixture {}

final class ObjectOfImplementationFixture implements ObjectOfContractFixture {}
