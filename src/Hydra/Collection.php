<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\Hydra;

use Symfony\Component\SerDes\Attribute\Name;
use Symfony\Component\SerDes\Attribute\Serializable;

/**
 * @template T
 */
#[Serializable]
final class Collection
{
    #[Name('hydra:member')]
    /** @var list<T> */
    public array $collection;

    #[Name('@type')]
    public string $type = 'hydra:Collection';

    #[Name('@context')]
    public string $context;

    #[Name('@id')]
    public string $id;

    #[Name('hydra:totalItems')]
    public int $totalItems = 0;
}
