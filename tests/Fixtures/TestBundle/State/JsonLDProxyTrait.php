<?php

declare(strict_types=1);

namespace ApiPlatform\Tests\Fixtures\TestBundle\State;

use Symfony\Component\SerDes\Attribute\Name;

trait JsonLDProxyTrait
{
    #[Name('@type')]
    public string $type;

    #[Name('@id')]
    public string $id;
}
