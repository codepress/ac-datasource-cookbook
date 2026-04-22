# Recipe 03: Defined Columns & Table Filtering

Where recipes 01 and 02 let Admin Columns auto-detect columns, this recipe
takes full control by doing two things, in order:

1. **Whitelist** which columns are allowed through via an `INCLUDE` filter.
2. **Define the type** of each allowed column so it renders, sorts, and
   filters the way you want.

## What it demonstrates

- `Facade\Table::from(...)->filter(new Name([...], Name::INCLUDE))`: only
  the listed columns pass through. Anything else on the table is ignored.
- `ColumnType\TextType`, `DateTimeType`, `BooleanType`, `WordPressUserType`:
  four of the most common built-in column types.
- Customising date formats via `DateTimeType::for($column, $format)`.
- `ToggleOptions::create_from_values()`: maps stored values to a boolean
  display (e.g. `"closed"/"open"` becomes a false/true toggle).

## Key takeaway

Whitelist first, type second. The `INCLUDE` filter gives you a deliberate,
stable list of columns regardless of what the underlying table happens to
contain. Typing each of those columns then gives you control over how they
render, sort, filter, and edit.

## Source

See [`example.php`](./example.php).
