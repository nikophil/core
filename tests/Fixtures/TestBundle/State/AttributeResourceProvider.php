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

namespace ApiPlatform\Tests\Fixtures\TestBundle\State;

use ApiPlatform\Hydra\Collection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Tests\Fixtures\TestBundle\Entity\AttributeResource;
use ApiPlatform\Tests\Fixtures\TestBundle\Entity\AttributeResources;
use ApiPlatform\Tests\Fixtures\TestBundle\Entity\Dummy;
use Symfony\Component\VarExporter\ProxyHelper;

class AttributeResourceProvider implements ProviderInterface
{
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): AttributeResources|AttributeResource|Collection
    {
        if (isset($uriVariables['identifier'])) {
            $resource = new AttributeResource($uriVariables['identifier'], 'Foo');

            // if ($uriVariables['dummyId'] ?? false) {
            //     $resource->dummy = new Dummy();
            //     $resource->dummy->setId($uriVariables['dummyId']);
            // }

            return $resource;
        }

        $collection = new Collection();

        $class = $this->proxy();

        $var = new $class(1, 'Foo');
        $var->id = '/attribute_resources/1';
        $var->type = $context['operation']->getShortName();

        $var2 = new $class(2, 'Bar');
        $var2->id = '/attribute_resources/2';
        $var2->type = $context['operation']->getShortName();

        $collection->collection = [$var, $var2];
        $collection->context = "/contexts/{$context['operation']->getShortName()}";
        $collection->id = $context['request_uri'];

        return $collection;
        // return new AttributeResources(new AttributeResource(1, 'Foo'), new AttributeResource(2, 'Bar'));
    }

    private function proxy(): string
    {
        $proxyClass = \str_replace('\\', '', AttributeResource::class).'Proxy';

        if (\class_exists($proxyClass)) {
            return $proxyClass;
        }

        $class = AttributeResource::class;
        $trait = JsonLDProxyTrait::class;
        $proxyCode = <<<PROXY
class $proxyClass extends $class
{
    use $trait;
}
PROXY;

        eval($proxyCode);

        return $proxyClass;
    }
}
