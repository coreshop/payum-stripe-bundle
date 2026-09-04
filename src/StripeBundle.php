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

namespace CoreShop\Payum\StripeBundle;

use CoreShop\Bundle\EnterpriseSubscriptionBundle\CoreShopEnterpriseSubscriptionBundle;
use CoreShop\Payum\StripeBundle\DependencyInjection\Compiler\PayumGatewayConfigOverride;
use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Pimcore\HttpKernel\Bundle\DependentBundleInterface;
use Pimcore\HttpKernel\BundleCollection\BundleCollection;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class StripeBundle extends AbstractPimcoreBundle implements DependentBundleInterface
{
    use PackageVersionTrait;

    public static function registerDependentBundles(BundleCollection $collection): void
    {
        $collection->addBundle(new CoreShopEnterpriseSubscriptionBundle());
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new PayumGatewayConfigOverride([
            'stripe_js' => [
                'payum.template.layout' => '@CoreShopPayum/layout.html.twig',
            ],
        ]));

        parent::build($container);
    }

    public function getNiceName(): string
    {
        return 'CoreShop - Stripe';
    }

    public function getDescription(): string
    {
        return 'Stripe Checkout and Stripe.js payment gateways for CoreShop';
    }

    protected function getComposerPackageName(): string
    {
        return 'coreshop/payum-stripe-bundle';
    }
}
