<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ThrowablePayloadTest extends TestCase
{
    #[Test]
    public function object_of_marker_class_accepts_marked_instance(): void
    {
        $this->assertSame(true, Types::matches(new ThrowablePayloadFixture(), new ObjectOf(ThrowablePayloadFixture::class)));
    }

    #[Test]
    public function object_of_marker_class_rejects_foreign_object(): void
    {
        $this->assertSame(false, Types::matches(new stdClass(), new ObjectOf(ThrowablePayloadFixture::class)));
    }
}

final class ThrowablePayloadFixture implements ThrowablePayload {}
