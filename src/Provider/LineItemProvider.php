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
use CoreShop\Component\Core\Model\OrderItemInterface;
use CoreShop\Component\Order\Model\AdjustmentInterface;

final class LineItemProvider implements LineItemProviderInterface
{
    /** @var LineItemImagesProviderInterface */
    private $lineItemImagesProvider;

    /** @var LinetItemNameProviderInterface */
    private $lineItemNameProvider;

    public function __construct(
        LineItemImagesProviderInterface $lineItemImagesProvider,
        LinetItemNameProviderInterface $lineItemNameProvider,
    ) {
        $this->lineItemImagesProvider = $lineItemImagesProvider;
        $this->lineItemNameProvider = $lineItemNameProvider;
    }

    public function getLineItem(OrderItemInterface $orderItem): ?array
    {
        /** @var OrderInterface|null $order */
        $order = $orderItem->getOrder();

        if (null === $order) {
            return null;
        }

        $currency = $order->getCurrency();

        if (null === $currency) {
            return null;
        }

        $itemAmount = $this->getLineItemAmount($orderItem);

        if ($itemAmount < 1) {
            return null;
        }

        return [
            'quantity' => 1,
            'price_data' => [
                'currency' => $currency->getIsoCode(),
                'unit_amount' => $itemAmount,
                'product_data' => [
                    'name' => $this->lineItemNameProvider->getItemName($orderItem),
                    'images' => $this->lineItemImagesProvider->getImageUrls($orderItem),
                ],
            ],
        ];
    }

    private function getLineItemAmount(OrderItemInterface $orderItem): int
    {
        $totalCartPriceRuleAdjustments = 0;
        foreach ($orderItem->getAdjustments(AdjustmentInterface::CART_PRICE_RULE) as $adjustment) {
            if ($adjustment->getNeutral()) {
                $totalCartPriceRuleAdjustments += $adjustment->getAmount();
            }
        }

        return $orderItem->getTotal() + $totalCartPriceRuleAdjustments;
    }
}
