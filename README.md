# CoreShop Stripe Payum Bundle

Stripe Checkout (`stripe_checkout`) and Stripe.js (`stripe_js`) payment gateways for CoreShop, built on
[FLUX-SE/PayumStripe](https://github.com/FLUX-SE/PayumStripe).

| Branch   | CoreShop | Pimcore | PHP       |
|----------|----------|---------|-----------|
| `2026.x` | 2026.x   | 2026    | 8.4, 8.5  |
| `3.x`    | 5.1      | 12      | 8.3, 8.4  |
| `2.x`    | 3 / 4    | 10 / 11 | 8.0+      |

## Installation

```bash
composer require coreshop/payum-stripe-bundle:^3.0
bin/console pimcore:bundle:enable StripeBundle
```

## Configuration

In the Pimcore admin (classic ExtJS or Pimcore Studio) open *CoreShop → Payment Providers*, add a provider and choose the factory `stripe_checkout` or
`stripe_js`. The form asks for

- **Publishable key** and **Secret key** of your Stripe account,
- **Webhook secret keys**, comma separated if you use more than one endpoint.

Register a webhook endpoint in Stripe pointing to your shop's Payum notify URL (`/payment/notify/...`, see the
Payum documentation) so that asynchronous payment updates reach CoreShop.

Optional settings for the Stripe Checkout line items:

```yaml
coreshop_payum_stripe_checkout:
    line_item_image:
        thumbnail_name: coreshop_productDetail
        fallback_image: 'https://placehold.it/400x300'
```

## Development

The repository contains a runnable test app (`bin/console`, `docker-compose.yaml`). Static checks:

```bash
vendor/bin/ecs check src
vendor/bin/phpstan
vendor/bin/psalm
```
