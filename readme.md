# AC Datasource Cookbook

A set of annotated code examples that show how to register custom
**Data Sources** for [Admin Columns Pro](https://www.admincolumns.com/).

Every folder under [`examples/`](./examples) is a self-contained example.
Each folder has its own `readme.md` explaining what the example does and
an `example.php` with the code. Read them in order. Each example builds on
the previous one.

## Requirements

- WordPress 5.9 or later
- PHP 7.4 or later
- Admin Columns Pro
- The **Data Sources** addon (bundled with ACP)

## Installation

1. Copy or clone this directory into `wp-content/plugins/`.
2. Activate **AC Datasource Cookbook** from the WordPress plugins screen.
3. A **Datasources** item appears in the WordPress admin sidebar. Each
   enabled example shows up as a submenu below it.

## Enabling and disabling examples

All examples are enabled by default. Open [`bootstrap.php`](./bootstrap.php) and
comment out the `require` lines for the examples you do not want to load:

```php
require __DIR__ . '/examples/01-simple-users/example.php';
// require __DIR__ . '/examples/02-posts-labels/example.php';
require __DIR__ . '/examples/03-defined-columns/example.php';
```

Each example is independent. You can enable any combination.

## The examples

| #  | Example                                              | What it teaches                                                                |
|----|------------------------------------------------------|--------------------------------------------------------------------------------|
| 01 | [Simple Users](./examples/01-simple-users/)          | The minimum: register a table as a Data Source with no configuration.          |
| 02 | [Posts Labels](./examples/02-posts-labels/)          | Human-readable column labels plus a couple of typed columns.                   |
| 03 | [Defined Columns](./examples/03-defined-columns/)    | Declare columns explicitly and filter which columns are exposed.               |
| 04 | [Table Relation](./examples/04-table-relation/)      | Join tables into a Data Source via `has_one` Table and Attribute relations.    |
| 05 | [WooCommerce Orders](./examples/05-wc-orders/)       | Build a custom Orders screen combining four WooCommerce tables.                |

Some examples require a specific plugin (for instance WooCommerce). When
that is the case, the example's `readme.md` has a **Requirements** section
listing which plugin must be active.

## WooCommerce examples

WooCommerce stores data across many tables but only ships admin screens
for a handful of them. Analytics lookups, line-item data, and order
meta live in the database but have no dedicated dashboard. The
WooCommerce examples show how to use Data Sources to fill those gaps by
building custom admin tables on top of the WooCommerce schema.

Start at Example 05 for an Orders screen that combines `wp_wc_orders`
with its meta, analytics stats, and line-item lookup tables.

## API reference

See the [API reference](./docs/api-reference.md) for class and helper
documentation, grouped by topic: registration, tables, columns, and
relations.
