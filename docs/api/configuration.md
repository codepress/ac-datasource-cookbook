# Column configuration

Classes used to shape which columns appear on a Data Source and how their
labels are produced.

## `ACA\DataSources\DataSource\Config\Columns`

Immutable builder for column configuration.

```php
Config\Columns::create(): self
$config->with_columns(array $columns): self        // Config\Column[]
$config->with_column(Config\Column $column): self
$config->with_label_resolver(ColumnLabelResolver $resolver): self
$config->with_identifier(Config\Identifier $identifier): self
```

Any column declared via `with_columns()` overrides the auto-detected type
for that column. Columns not declared still appear with default rendering.

## `ACA\DataSources\DataSource\ColumnLabelResolver\HumanReadableResolver`

Turns raw column names into Title Case labels (`comment_author_email` →
"Comment Author Email"). Plug into
`Config\Columns::with_label_resolver()`.

```php
new HumanReadableResolver()
```

## `ACA\DataSources\Repository\Database\Table\Filter\Name`

Hides or keeps only specific columns on a resolved `Table`. Apply via
`Table::filter()`.

```php
new Name(array $column_names, ?int $mode = null)
```

Modes:

| Constant                  | Effect                                         |
|---------------------------|------------------------------------------------|
| `Name::INCLUDE` (default) | Keep only the listed columns.                  |
| `Name::EXCLUDE`           | Hide the listed columns; keep everything else. |

## `ACA\DataSources\Repository\Database\Table\Resolver`

The underlying resolver used by [`Facade\Table`](facades.md#acadatasourcesfacadetable).
Useful when you want the raw `Table` object without going through the
facade.

```php
(new Resolver())->resolve(string $table, ?string $identifier = null): Table
```
