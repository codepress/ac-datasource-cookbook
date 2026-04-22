# Example 04: Table-to-Table Relation (has_one)

Up until now each Data Source has been a single table. Real data models
usually have relationships. This example joins a second table into a
Data Source so its columns become available alongside the primary
table's columns.

**Scenario:** register `wp_comments` as the primary Data Source and
attach columns from `wp_posts` via a `has_one` relation. Each comment
references one post through `comment_post_ID`.

## What it demonstrates

- Registering multiple Data Sources in a single callback.
- `Facade\Relation\Table::has_one()`: joins two Data Sources on a
  foreign-key column. Each primary row pairs with exactly one foreign
  row in the result.
- `Facade\Relations`: the container that holds one or more relations for
  a Data Source.
- Registering a foreign Data Source without a menu page: use
  `new Entry($data_source)` to put it in the registry without calling
  `set_submenu()` or `set_menu()`.
- Reusing a table column filter (see Example 03) to limit which columns
  of the foreign table are exposed.

## Key takeaway

A related Data Source must itself be a registered Data Source, even if
it has no menu of its own. Register the foreign Data Source first
(here: posts), then reference it when building the primary Data Source
(here: comments).

## Signature

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

## Note on `has_many`

Swap `Facade\Relation\Table::has_one(...)` for `::has_many(...)` when a
single primary row can match many foreign rows (e.g. make posts the
primary Data Source and join many comments per post). The Data Sources
addon aggregates the foreign values per row.

## Source

See [`example.php`](./example.php).
