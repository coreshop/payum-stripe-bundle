<?php

return [
    Pimcore\Bundle\GenericExecutionEngineBundle\PimcoreGenericExecutionEngineBundle::class => ['dev' => true],
    Pimcore\Bundle\AdminBundle\PimcoreAdminBundle::class => ['all' => true],
    Pimcore\Bundle\OpenSearchClientBundle\PimcoreOpenSearchClientBundle::class => ['dev' => true],
    Pimcore\Bundle\GenericDataIndexBundle\PimcoreGenericDataIndexBundle::class => ['dev' => true],
    Pimcore\Bundle\StaticResolverBundle\PimcoreStaticResolverBundle::class => ['dev' => true],
    Pimcore\Bundle\StudioBackendBundle\PimcoreStudioBackendBundle::class => ['dev' => true],
    Pimcore\Bundle\StudioUiBundle\PimcoreStudioUiBundle::class => ['dev' => true],
    \CoreShop\Bundle\CoreBundle\CoreShopCoreBundle::class => ['all' => true],
    \CoreShop\Payum\StripeBundle\StripeBundle::class => ['all' => true],
    \CoreShop\Bundle\FrontendBundle\CoreShopFrontendBundle::class => ['all' => true],
];
