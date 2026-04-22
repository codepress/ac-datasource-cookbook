# Recipe 03 — Defined Columns & Table Filtering

Where recipes 01 and 02 let Admin Columns auto-detect columns, this recipe
takes more control:

- Each exposed column is declared up front with an explicit type.
- Specific columns can be excluded from the listing entirely.

## What it demonstrates

- [`ColumnType\TextType`](../api/column-types.md),
  [`DateTimeType`](../api/column-types.md),
  [`BooleanType`](../api/column-types.md),
  [`WordPressUserType`](../api/column-types.md) — four of the most common
  built-in column types.
- Customising date formats via `DateTimeType::for($column, $format)`.
- [`ToggleOptions::create_from_values()`](../api/helpers.md) — maps stored
  values to a boolean display (e.g. `"closed"/"open"` → false/true toggle).
- [`Facade\Table::from(...)->filter(new Name([...], Name::EXCLUDE))`](../api/configuration.md#acadatasourcesrepositorydatabasetablefiltername)
  — hides columns from the table before they reach the UI.

## Key takeaway

Typing columns explicitly gives you control over rendering, sorting,
filtering, and editing behaviour. Combine it with a table filter to hide
columns you don't want to expose (e.g. internal timestamps, duplicate GMT
fields).

## Source

```php title="examples/03-defined-columns.php"
--8<-- "examples/03-defined-columns.php"
```
