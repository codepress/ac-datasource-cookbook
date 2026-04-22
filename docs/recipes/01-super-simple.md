# Recipe 01 — Super Simple

The absolute minimum required to turn any database table into an Admin
Columns-powered overview page. This recipe registers the `wp_users` table
with no custom configuration at all. Admin Columns will:

- Auto-detect every column from the table schema.
- Generate reasonable default column types from the SQL column types.
- Generate default labels from the column names.

## What it demonstrates

- The [`acp/data-sources/register`](../api/hook.md) action — the single
  entry point for adding Data Sources.
- The [`Facade\Table::from()`](../api/facades.md#acadatasourcesfacadetable)
  helper that wraps table resolution.
- Creating a [`DataSource`](../api/core.md#acadatasourcesdatasource) with
  only an ID and a table.
- Registering an [`Entry`](../api/core.md#acadatasourcesdatasourceregistryentry)
  with `set_submenu()` so the page appears in the WordPress admin.

## Key takeaway

If a table exists in the database, you can make it browsable in under ten
lines of code.

## Source

```php title="examples/01-super-simple.php"
--8<-- "examples/01-super-simple.php"
```
