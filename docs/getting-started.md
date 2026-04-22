# Getting started

## Installation

1. Copy or clone the cookbook directory into `wp-content/plugins/`.
2. Activate **AC Datasource Cookbook** from the WordPress plugins screen.
3. A **DS Cookbook** item appears in the WordPress admin sidebar. Each
   enabled recipe shows up as a submenu below it.

!!! info "Admin Columns Pro is required"
    The cookbook is not a standalone plugin — it registers Data Sources
    against the API provided by Admin Columns Pro and its Data Sources
    addon. Both must be installed and active.

## Enabling and disabling recipes

All recipes are enabled by default. Open
[`bootstrap.php`](https://github.com/codepress/ac-datasource-cookbook/blob/main/bootstrap.php)
and comment out the `require` lines for the recipes you do not want to load:

```php
require __DIR__ . '/examples/01-super-simple.php';
// require __DIR__ . '/examples/02-human-readable.php';
require __DIR__ . '/examples/03-defined-columns.php';
```

Each recipe is independent. You can enable any combination.

## How a recipe is organised

Every file under `examples/` follows the same shape:

1. **Header docblock** — what the recipe demonstrates and the key takeaway.
2. **`use` statements** — every class the recipe references, grouped by
   namespace.
3. **A single `add_action('acp/data-sources/register', …)` callback** —
   the one and only place where Data Sources are registered.
4. **Inline comments** — step-by-step explanations next to the code they
   describe.

## Plugin-dependent recipes

Some recipes require a specific plugin (for example WooCommerce). When that
is the case, the recipe's header docblock starts with a `Requires:` line
stating which plugin must be active. Those recipes guard themselves at the
top of the file and no-op silently when the dependency is missing.

## Next step

Head over to the [recipes overview](recipes/index.md) and start with
Recipe 01.
