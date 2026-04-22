# Recipe 02 — Human-Readable Labels & Typed Columns

Two small improvements over Recipe 01:

1. A `HumanReadableResolver` is used as the label resolver. It turns raw
   column names like `comment_post_ID` into friendly headings such as
   "Comment Post Id" without having to label each column individually.
2. A handful of columns are explicitly typed. Typed columns render with
   richer output (links, avatars, thumbnails) instead of the raw database
   value.

## What it demonstrates

- [`Config\Columns::create()`](../api/configuration.md#acadatasourcesdatasourceconfigcolumns)
  — the builder for column configuration.
- `->with_label_resolver()` — controls how column labels are derived.
- `->with_columns([...])` — overrides a subset of columns with typed
  variants; the remaining columns still get default rendering.
- [`ColumnType\WordPressPostType`](../api/column-types.md) and
  [`ColumnType\WordPressUserType`](../api/column-types.md) — built-in
  column types that render linked post/user references.
- [`Repository\Database\Table\Resolver`](../api/configuration.md#acadatasourcesrepositorydatabasetableresolver)
  — the same thing `Facade\Table` uses internally, shown here so you can
  see there is no magic.

## Key takeaway

You do not need to configure every column. Type only the ones that benefit
from richer rendering; let the label resolver handle the rest.

## Source

```php title="examples/02-human-readable.php"
--8<-- "examples/02-human-readable.php"
```
