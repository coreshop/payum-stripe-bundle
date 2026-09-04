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

final class DetailsProvider implements DetailsProviderInterface
{
    /** @var CustomerEmailProviderInterface */
    private $customerEmailProvider;

    /** @var LineItemsProviderInterface */
    private $lineItemsProvider;

    /** @var PaymentMethodTypesProviderInterface */
    private $paymentMethodTypesProvider;

    /** @var LocaleProviderInterface */
    private $localeProvider;

    public function __construct(
        CustomerEmailProviderInterface $customerEmailProvider,
        LineItemsProviderInterface $lineItemsProvider,
        PaymentMethodTypesProviderInterface $paymentMethodTypesProvider,
        LocaleProviderInterface $localeProvider,
    ) {
        $this->customerEmailProvider = $customerEmailProvider;
        $this->paymentMethodTypesProvider = $paymentMethodTypesProvider;
        $this->lineItemsProvider = $lineItemsProvider;
        $this->localeProvider = $localeProvider;
    }

    public function getDetails(OrderInterface $order): array
    {
        $details = [];

        $customerEmail = $this->customerEmailProvider->getCustomerEmail($order);
        if (null !== $customerEmail) {
            $details['customer_email'] = $customerEmail;
        }

        $lineItems = $this->lineItemsProvider->getLineItems($order);
        if ([] !== $lineItems) {
            $details['line_items'] = $lineItems;
            $details['mode'] = 'payment';
        }

        $details['payment_method_types'] = $this->paymentMethodTypesProvider->getPaymentMethodTypes($order);

        $locale = $this->localeProvider->getLocale($order);
        if (null !== $locale) {
            $details['locale'] = $locale;
        }

        return $details;
    }
}
