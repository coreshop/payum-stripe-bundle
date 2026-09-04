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

final class LineItemsProvider implements LineItemsProviderInterface
{
    /** @var LineItemProviderInterface */
    private $lineItemProvider;

    /** @var ShippingLineItemProviderInterface */
    private $shippingLineItemProvider;

    public function __construct(
        LineItemProviderInterface $lineItemProvider,
        ShippingLineItemProviderInterface $shippingLineItemProvider,
    ) {
        $this->lineItemProvider = $lineItemProvider;
        $this->shippingLineItemProvider = $shippingLineItemProvider;
    }

    public function getLineItems(OrderInterface $order): array
    {
        $lineItems = [];
        foreach ($order->getItems() ?? [] as $orderItem) {
            $lineItem = $this->lineItemProvider->getLineItem($orderItem);
            if (null !== $lineItem) {
                $lineItems[] = $lineItem;
            }
        }

        $lineItem = $this->shippingLineItemProvider->getLineItem($order);
        if (null !== $lineItem) {
            $lineItems[] = $lineItem;
        }

        return $lineItems;
    }
}
