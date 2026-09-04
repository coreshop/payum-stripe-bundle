# Changelog

## 3.0.0 (unreleased)

- Ported to CoreShop 5.1 / Pimcore 12 (PHP 8.3, 8.4). Gateway configuration works in the classic ExtJS admin
  (existing gateway panels) and in Pimcore Studio, where the form is rendered from the Symfony form types
  (`coreshop.studio_form`).
- Bundle layout follows the other CoreShop bundles (flat `src/`, runnable test app, shared CI workflows).
- `flux-se/payum-stripe` ^2.1.
