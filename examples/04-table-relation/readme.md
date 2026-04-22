# Example 04: Table Relations (`has_one`)

Up until now each Data Source has been a single table. Real data models
usually have relationships. This example joins two other tables into a
primary Data Source so their columns become available alongside the
primary table's columns.

**Scenario:** register `wp_comments` as the primary Data Source and
attach:

1. Columns from `wp_posts` via a **Table relation** (each comment has
   one post, referenced by `comment_post_ID`).
2. A configurable column from `wp_commentmeta` via an **Attribute
   relation**. The column lets the user pick which `meta_key` to
   display; it can be added to the table multiple times to show
   different keys side-by-side (same mechanic as the built-in Custom
   Field column).

This second pattern is common in WordPress: `posts` + `postmeta`,
`users` + `usermeta`, `terms` + `termmeta`, `comments` + `commentmeta`.

## What it demonstrates

- Registering multiple Data Sources in a single callback.
- `Facade\Relation\Table::has_one()`: joins two tables on a foreign-key
  column. Each primary row pairs with exactly one foreign row.
- `Facade\Relation\Attribute::has_one()`: joins a key/value (meta)
  table and exposes a configurable column where the user picks which
  key to display. The column can be added multiple times for different
  keys.
- `Facade\Relations`: the container that holds one or more relations for
  a Data Source.
- `Facade\DataSource::from()`: shortcut to create a Data Source from a
  table name when no custom columns are needed.
- Registering a foreign Data Source without a menu page: use
  `new Entry($data_source)` without calling `set_submenu()` or
  `set_menu()`.
- Reusing a table column filter (see Example 03) to limit which columns
  of the foreign table are exposed.

## Key takeaway

A related Data Source must itself be a registered Data Source, even if
it has no menu of its own. Register all foreign Data Sources first,
then reference them when building the primary Data Source.

## Table relation signature

Joins on a foreign-key column. Use when the foreign table has one row
per related entity (like `wp_posts` related to `wp_comments`).

```php
Facade\Relation\Table::has_one(
    DataSource $foreign_data_source,
    string $foreign_column,        // column in the foreign table
    ?string $local_column = null,  // column in the primary table
    ?Alias $alias = null,
    ?JoinType $join_type = null
)
```

`$local_column` defaults to the primary key of the local table. Pass it
explicitly when the join uses a different column, as in this example
where `comment_post_ID` is the foreign key (not the primary key
`comment_ID`).

## Attribute relation signature

Joins a vertical key/value table (meta-style) and exposes a single
configurable column on the primary Data Source. The user picks which
key to show via a dropdown in the column settings, and can add the same
column multiple times to display different keys. This works the same
way as Admin Columns' built-in Custom Field column.

```php
Facade\Relation\Attribute::has_one(
    DataSource $foreign_data_source,
    string $foreign_column,         // meta table column pointing at the primary row
    string $label,                  // group label shown in the column picker
    string $foreign_attribute,      // the "key" column (e.g. `meta_key`)
    string $foreign_value_column,   // the "value" column (e.g. `meta_value`)
    ?string $local_column = null
)
```

Typical arguments for the standard WordPress meta tables:

| Primary table | Meta table        | `$foreign_column` | `$foreign_attribute` | `$foreign_value_column` |
|---------------|-------------------|-------------------|----------------------|-------------------------|
| `wp_posts`    | `wp_postmeta`     | `post_id`         | `meta_key`           | `meta_value`            |
| `wp_users`    | `wp_usermeta`     | `user_id`         | `meta_key`           | `meta_value`            |
| `wp_terms`    | `wp_termmeta`     | `term_id`         | `meta_key`           | `meta_value`            |
| `wp_comments` | `wp_commentmeta`  | `comment_id`      | `meta_key`           | `meta_value`            |

## Note on `has_many`

Swap `::has_one(...)` for `::has_many(...)` on either relation type
when a single primary row can match many foreign rows. The Data Sources
addon aggregates the foreign values per row. Example: make posts the
primary Data Source and join many comments per post with
`Table::has_many()`.

## Source

See [`example.php`](./example.php).
