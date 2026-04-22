# Recipe 04: Table-to-Table Relation (has_one)

Up until now each Data Source has been a single table. Real data models
usually have relationships. This recipe joins a second table into a Data
Source so its columns become available alongside the primary table's
columns.

**Scenario:** register `wp_posts` and add columns from the related
`wp_comments` table via a `has_one` relation (one post, one comment row
in the join).

## What it demonstrates

- Registering multiple Data Sources in a single callback.
- `Facade\Relation\Table::has_one()`: joins two Data Sources on a
  foreign-key column. Both sides share the same row when queried.
- `Facade\Relations`: the container that holds one or more relations for
  a Data Source.
- Reusing a table filter to hide a column (see Recipe 03).

## Key takeaway

A related Data Source must itself be a Data Source. Register the "foreign"
Data Source (here: comments) first, then reference it when building the
primary Data Source (posts).

## Note on `has_many`

Swap `Facade\Relation\Table::has_one(...)` for `::has_many(...)` when a
single primary row can match many foreign rows (e.g. one post has many
comments). The Data Sources addon will aggregate the values per row.

## Source

See [`example.php`](./example.php).
