# Changelog

## 2026.1.0 (unreleased)

- Ported to CoreShop 2026.x / Pimcore 2026 (PHP 8.4, 8.5). Gateway configuration is rendered by Pimcore Studio from the
  Symfony form types (`coreshop.studio_form`); the ExtJS admin files were removed.
- Bundle layout follows the other CoreShop bundles (flat `src/`, runnable test app, shared CI workflows).
- Requires `coreshop/enterprise-subscription-bundle` (CoreShop Commercial License).
- `flux-se/payum-stripe` ^2.1.
