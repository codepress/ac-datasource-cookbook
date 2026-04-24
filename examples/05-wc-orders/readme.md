# Example 05: WooCommerce Orders with Relations

## Why WooCommerce

WooCommerce stores data across many tables but only ships admin screens
for a handful of them. Analytics lookups, line-item data, and meta
values live in the database but have no dedicated dashboard. Data
Sources lets you build your own admin tables for the data WooCommerce
holds but does not surface.

This example demonstrates that by combining four WooCommerce tables
into a single Orders screen.

**Tables used:**

- `wp_wc_orders` — the primary HPOS orders table.
- `wp_wc_orders_meta` — key/value order meta (Attribute relation).
- `wp_wc_order_stats` — analytics stats, one row per order (Table
  `has_one`).
- `wp_wc_order_product_lookup` — line-item analytics, many rows per
  order (Table `has_many`).

The resulting screen lets you show, sort, and filter on any combination
of columns from these four tables in one view.

## Requirements

- **WooCommerce** must be active.
- **HPOS** (High-Performance Order Storage) must be enabled, otherwise
  the `wp_wc_orders` table does not exist. Enable it under
  *WooCommerce → Settings → Advanced → Features*.

## What it demonstrates

- Three relations of different types attached to one primary Data
  Source (builds on Example 04 which had two).
- Using `WordPressUserType`, `WordPressPostType`, and `EmailType` to
  render IDs and strings as linked users, linked products, and
  `mailto:` links instead of raw values.
- Handling a **composite primary key**. The
  `wp_wc_order_product_lookup` table has
  `PRIMARY KEY (order_item_id, order_id)`, which the identifier
  auto-detection rejects. Because `Facade\DataSource::from()` does not
  support an identifier override, we build that Data Source with
  `new DataSource(...)` and pass `order_item_id` explicitly to
  `Facade\Table::from()`.
- Loading the example conditionally using a
  `class_exists('WooCommerce')` guard at the top of the file, so the
  code is safe to ship even when WooCommerce is not active.

## Why this pattern is useful

WooCommerce's default admin shows orders, but the view is fixed. If
you want to see meta values, analytics totals, or line-item data
alongside the order itself, the default screen cannot do that without
custom code. This example builds an alternate orders screen where
every related piece of data is one click away in the Admin Columns
column picker.

## Relations used

| Table                          | Relation type       | Why                                                   |
|--------------------------------|---------------------|-------------------------------------------------------|
| `wp_wc_orders_meta`            | Attribute `has_one` | One configurable column; pick any `meta_key`.         |
| `wp_wc_order_stats`            | Table `has_one`     | Exactly one analytics row per order.                  |
| `wp_wc_order_product_lookup`   | Table `has_many`    | Multiple line items per order; values are aggregated. |

## Source

See [`example.php`](./example.php).
