<?php

declare(strict_types=1);

/*
 * CoreShop
 *
 * This source file is available under two different licenses:
 *  - GNU General Public License version 3 (GPLv3)
 *  - CoreShop Commercial License (CCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.com)
 * @license    https://www.coreshop.com/license     GPLv3 and CCL
 *
 */

namespace CoreShop\Payum\StripeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class PayumGatewayConfigOverride implements CompilerPassInterface
{
    /**
     * @param array<string, array<string, mixed>> $gatewayConfigs
     */
    public function __construct(
        private readonly array $gatewayConfigs,
    ) {
    }

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container): void
    {
        $builder = $container->getDefinition('payum.builder');
        foreach ($this->gatewayConfigs as $gatewayName => $factoryConfig) {
            $builder->addMethodCall('addGatewayFactoryConfig', [$gatewayName, $factoryConfig]);
        }
    }
}
