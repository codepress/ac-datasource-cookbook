# AC Datasource Cookbook

A collection of annotated code examples that show how to register custom
**Data Sources** for [Admin Columns Pro](https://www.admincolumns.com/).

Every file under [`examples/`](./examples) is a self-contained recipe. Read
them top to bottom — each one is heavily commented and builds on the
concepts introduced by the previous recipe.

## Requirements

- WordPress 5.9 or later
- PHP 7.4 or later
- Admin Columns Pro
- The **Data Sources** addon (bundled with ACP)

## Installation

1. Copy or clone this directory into `wp-content/plugins/`.
2. Activate **AC Datasource Cookbook** from the WordPress plugins screen.
3. A **DS Cookbook** item appears in the WordPress admin sidebar. Each enabled
   recipe shows up as a submenu below it.

## Enabling and disabling recipes

All recipes are enabled by default. Open [`bootstrap.php`](./bootstrap.php) and
comment out the `require` lines for the recipes you do not want to load:

```php
require __DIR__ . '/examples/01-super-simple.php';
// require __DIR__ . '/examples/02-human-readable.php';
require __DIR__ . '/examples/03-defined-columns.php';
```

Each recipe is independent. You can enable any combination.

## The recipes

| # | File | What it teaches |
| --- | --- | --- |
| 01 | [`01-super-simple.php`](./examples/01-super-simple.php) | The absolute minimum: register a table as a Data Source with no configuration. |
| 02 | [`02-human-readable.php`](./examples/02-human-readable.php) | Human-readable column labels plus a couple of typed columns. |
| 03 | [`03-defined-columns.php`](./examples/03-defined-columns.php) | Declare columns explicitly and filter unwanted columns out of the table. |
| 04 | [`04-table-relation.php`](./examples/04-table-relation.php) | Join a second table into a Data Source via a `has_one` relation. |

Some recipes require a specific plugin (for example WooCommerce). When that
is the case, the recipe's header docblock starts with a `Requires:` line
stating which plugin must be active.

## API reference

See [`docs/api-reference.md`](./docs/api-reference.md) for a quick lookup of
every class and helper used in the recipes — namespaces, signatures, and
which recipe introduces each one.
