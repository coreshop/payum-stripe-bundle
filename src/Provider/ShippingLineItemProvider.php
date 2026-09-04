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

namespace CoreShop\Payum\StripeBundle\Provider;

use CoreShop\Component\Core\Model\OrderInterface;

final class ShippingLineItemProvider implements ShippingLineItemProviderInterface
{
    /** @var ShippingLineItemNameProviderInterface */
    private $shippingLineItemProvider;

    public function __construct(
        ShippingLineItemNameProviderInterface $shippingLineItemProvider,
    ) {
        $this->shippingLineItemProvider = $shippingLineItemProvider;
    }

    public function getLineItem(OrderInterface $order): ?array
    {
        $currency = $order->getCurrency();

        if (null === $currency || 0 === $order->getShipping(false)) {
            return null;
        }

        return [
            'quantity' => 1,
            'price_data' => [
                'currency' => $currency->getIsoCode(),
                'unit_amount' => $order->getShipping(),
                'product_data' => [
                    'name' => $this->shippingLineItemProvider->getItemName($order),
                ],
            ],
        ];
    }
}
