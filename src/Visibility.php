<?php

declare(strict_types=1);

enum Visibility: string
{
    case Private   = 'private';
    case Protected = 'protected';
    case Public    = 'public';
}
