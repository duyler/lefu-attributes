<?php

declare(strict_types=1);

#[Attribute(
    Attribute::TARGET_PROPERTY
    | Attribute::TARGET_METHOD
    | Attribute::TARGET_CLASS_CONSTANT,
)]
final readonly class VisibleAs
{
    public function __construct(public Visibility $visibility) {}
}
