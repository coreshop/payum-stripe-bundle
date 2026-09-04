# Configuration

## Payment provider

Create a payment provider in *CoreShop → Payment Providers* and choose the factory `stripe_checkout`
(hosted Stripe Checkout page) or `stripe_js` (Stripe.js on your own checkout page).

| Field | Description |
|---|---|
| Publishable key | Stripe publishable key (`pk_live_…` / `pk_test_…`) |
| Secret key | Stripe secret key (`sk_live_…` / `sk_test_…`) |
| Webhook secret keys | Signing secrets of the Stripe webhook endpoints, comma separated |

## Webhooks

Register a webhook endpoint in the Stripe dashboard that points to the Payum notify URL of your shop and
copy its signing secret into the provider configuration. Without a webhook, asynchronous payment states
(e.g. delayed payment methods) do not reach CoreShop.

## Line items (Stripe Checkout)

```yaml
coreshop_payum_stripe_checkout:
    line_item_image:
        thumbnail_name: coreshop_productDetail   # Pimcore thumbnail used for the product image
        fallback_image: 'https://placehold.it/400x300'
```
