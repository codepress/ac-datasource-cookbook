# AC Datasource Cookbook

A collection of annotated code examples that show how to register custom
**Data Sources** for [Admin Columns Pro](https://www.admincolumns.com/).

Every folder under [`examples/`](./examples) is a self-contained recipe.
Each folder has its own `readme.md` with a walkthrough and an `example.php`
with the code. Read them top to bottom. Each recipe builds on the
concepts introduced by the previous one.

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
require __DIR__ . '/examples/01-super-simple/example.php';
// require __DIR__ . '/examples/02-human-readable/example.php';
require __DIR__ . '/examples/03-defined-columns/example.php';
```

Each recipe is independent. You can enable any combination.

## The recipes

| #  | Recipe                                                             | What it teaches                                                                  |
|----|--------------------------------------------------------------------|----------------------------------------------------------------------------------|
| 01 | [Super Simple](./examples/01-super-simple/)                        | The absolute minimum: register a table as a Data Source with no configuration.   |
| 02 | [Human-Readable Labels](./examples/02-human-readable/)             | Human-readable column labels plus a couple of typed columns.                     |
| 03 | [Defined Columns](./examples/03-defined-columns/)                  | Declare columns explicitly and filter unwanted columns out of the table.         |
| 04 | [Table Relation](./examples/04-table-relation/)                    | Join a second table into a Data Source via a `has_one` relation.                 |

Some recipes require a specific plugin (for example WooCommerce). When
that is the case, the recipe's `readme.md` has a **Requirements** section
listing which plugin must be active.

## API reference

See [`docs/api-reference.md`](./docs/api-reference.md) for a quick lookup of
every class and helper used in the recipes: namespaces, signatures, and
which recipe introduces each one.
