<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class VisibilityTest extends TestCase
{
    #[Test]
    #[DataProvider('provide_cases')]
    public function cases_have_backed_values(Visibility $case, string $expected): void
    {
        $this->assertSame($expected, $case->value);
    }

    #[Test]
    public function is_not_part_of_the_type_hierarchy(): void
    {
        $this->assertSame(false, is_a(Visibility::class, Type::class, true));
    }

    public static function provide_cases(): array
    {
        return [
            'private' => [Visibility::Private, 'private'],
            'protected' => [Visibility::Protected, 'protected'],
            'public' => [Visibility::Public, 'public'],
        ];
    }
}
