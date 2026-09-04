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

final class ShippingLineItemNameProvider implements ShippingLineItemNameProviderInterface
{
    public function getItemName(OrderInterface $order): string
    {
        $carrier = $order->getCarrier();

        if (null === $carrier) {
            throw new \LogicException(
                'The order does not have a carrier !',
            );
        }

        $locale = $order->getLocaleCode();
        /** @psalm-suppress InvalidArgument the interface declares getTitle(?string) without a docblock type */
        $itemName = null !== $locale ? $carrier->getTitle($locale) : $carrier->getTitle();

        if ('' === $itemName) {
            $itemName = sprintf('Carrier ID: %s', $carrier->getId());
        }

        return $itemName;
    }
}
