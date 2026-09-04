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

use CoreShop\Component\Core\Model\OrderItemInterface;
use CoreShop\Component\Core\Model\ProductInterface;
use Pimcore\Model\Asset\Image;
use Pimcore\Tool;

final class LineItemImagesProvider implements LineItemImagesProviderInterface
{
    /** @var string */
    private $thumbnailName;

    /** @var string */
    private $fallbackImage;

    public function __construct(
        string $thumbnailName,
        string $fallbackImage,
    ) {
        $this->thumbnailName = $thumbnailName;
        $this->fallbackImage = $fallbackImage;
    }

    public function getImageUrls(OrderItemInterface $orderItem): array
    {
        $product = $orderItem->getProduct();

        if (!$product instanceof ProductInterface) {
            return [];
        }

        return [
            $this->getImageUrlFromProduct($product),
        ];
    }

    public function getImageUrlFromProduct(ProductInterface $product): string
    {
        $path = $this->fallbackImage;

        if (null !== $image = $product->getImage()) {
            /** @var Image $image */
            $imageThumbnail = $image->getThumbnail($this->thumbnailName);
            $path = $imageThumbnail->getPath();

            if (null === parse_url($path, \PHP_URL_SCHEME)) {
                $path = Tool::getHostUrl() . $path;
            }
        }

        return $this->getUrlFromPath($path);
    }

    private function getUrlFromPath(string $path): string
    {
        // Relative images are not displayed by Stripe because they cache it on a CDN
        if (null === parse_url($path, \PHP_URL_SCHEME)) {
            $path = $this->fallbackImage;
        }

        return $path;
    }
}
