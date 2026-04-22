# Tables

[Back to API reference](./api-reference.md)

Helpers for resolving a database table and filtering which of its
columns are exposed on the Data Source.

## `ACA\DataSources\Facade\Table`

Resolves a database table by name. Applies the current site's table
prefix automatically.

```php
Facade\Table::from(string $table, ?string $identifier = null): Repository\Database\Table
```

The returned `Table` exposes `->filter()` for keeping or hiding specific
columns. See `Filter\Name` below.

## `ACA\DataSources\Repository\Database\Table\Resolver`

The resolver that `Facade\Table` uses internally. Useful when you want
the raw `Table` object without the facade.

```php
(new Resolver())->resolve(string $table, ?string $identifier = null): Table
```

## `ACA\DataSources\Repository\Database\Table\Filter\Name`

Keeps or hides a list of columns on a resolved `Table`. Apply via
`Table::filter()`.

```php
new Name(array $column_names, ?int $mode = null)
```

| Constant                  | Effect                                         |
|---------------------------|------------------------------------------------|
| `Name::INCLUDE` (default) | Keep only the listed columns.                  |
| `Name::EXCLUDE`           | Hide the listed columns. Keep everything else. |
