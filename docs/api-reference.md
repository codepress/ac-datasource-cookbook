# API Reference

A quick lookup of every class and helper that appears in the cookbook
recipes. Each entry lists the namespace, a short description, and the
signature you are most likely to use.

Methods that return `self` in the listings are immutable — they return a
cloned instance with the change applied.

---

## The hook

### `acp/data-sources/register`

Fires once, after Admin Columns Pro has booted. This is the only place where
Data Sources should be registered.

```php
add_action('acp/data-sources/register', function (DataSourceRegistry $registry) {
    // register Data Sources here
});
```

---

## Core model

### `ACA\DataSources\DataSource`

The in-memory model of one browsable table. Combines an identifier, a table,
optional column configuration, and optional relations to other Data Sources.

```php
new DataSource(
    DataSourceId $id,
    Repository\Database\Table $table,
    ?Config\Columns $columns = null,
    ?RelationFactoryCollection $relations = null
)
```

### `ACA\DataSources\Type\DataSourceId`

Value object that wraps the unique string identifier of a Data Source. The
identifier must match `^[a-z][a-z0-9]*(_[a-z0-9]+)*$` (lowercase snake_case
starting with a letter).

```php
new DataSourceId('cookbook_users')
```

### `ACA\DataSources\DataSourceRegistry`

The registry passed into the `acp/data-sources/register` hook. Call
`register()` with an `Entry` to add a Data Source.

```php
$registry->register(Entry $entry): void
```

### `ACA\DataSources\DataSourceRegistry\Entry`

Wraps a `DataSource` with admin-UI metadata (menu placement, capabilities,
grouping) before registration.

```php
Entry::create(DataSource $data_source): self
$entry->set_menu(string $title, ?string $menu_title = null, ?string $icon = null, ?int $position = null): self
$entry->set_submenu(string $title, string $parent_slug, ?string $menu_title = null, ?int $position = null): self
$entry->set_group(AC\Type\Group $group): self
$entry->set_capabilities(Capabilities $capabilities): self
```

---

## Facades (recommended entry points)

The `Facade\*` classes are thin, static-method helpers that wrap the core
constructors. They accept plain strings and handle table resolution for you —
prefer them over building core objects manually.

### `ACA\DataSources\Facade\Table`

Resolves a database table by name and applies the current site's table
prefix automatically.

```php
Facade\Table::from(string $table, ?string $identifier = null): Repository\Database\Table
```

The returned `Table` exposes a `->filter()` method for hiding or keeping
specific columns — see `Filter\Name` below.

### `ACA\DataSources\Facade\DataSource`

Builds a `DataSource` from a table name in one call. Internally calls
`Facade\Table::from()` and the `DataSource` constructor.

```php
Facade\DataSource::from(
    string $table,
    string $data_source_id,
    ?Config\Columns $config = null,
    ?RelationFactoryCollection $relations = null
): DataSource
```

### `ACA\DataSources\Facade\Entry`

Builds a `DataSourceRegistry\Entry` directly from a table name. A one-call
shortcut for simple Data Sources that don't need customisation after
creation.

```php
Facade\Entry::from(
    string $table,
    string $data_source_id,
    ?Config\Columns $config = null,
    ?RelationFactoryCollection $relations = null
): DataSourceRegistry\Entry
```

### `ACA\DataSources\Facade\Relations`

A typed container for one or more relation factories. Pass the array of
relations you want to attach to a Data Source.

```php
new Facade\Relations([
    Facade\Relation\Table::has_one(...),
    Facade\Relation\Attribute::has_one(...),
])
```

### `ACA\DataSources\Facade\Relation\Table`

Joins two Data Sources on a foreign-key column. Use when the foreign table
has wide rows (one row per related entity).

```php
Facade\Relation\Table::has_one(
    DataSource $foreign_data_source,
    string $foreign_column,
    ?string $local_column = null,
    ?ACP\Sql\Alias $alias = null,
    ?ACP\Sql\JoinType $join_type = null
): TableRelationFactory

Facade\Relation\Table::has_many(/* same args */): TableRelationFactory
```

`$local_column` defaults to the primary key of the local table.

### `ACA\DataSources\Facade\Relation\Attribute`

Joins to a vertical key/value table (postmeta-style) and pivots each distinct
key into its own column on the parent Data Source.

```php
Facade\Relation\Attribute::has_one(
    DataSource $foreign_data_source,
    string $foreign_column,
    string $label,
    string $foreign_attribute,
    string $foreign_value_column,
    ?string $local_column = null
): AttributeRelationFactory

Facade\Relation\Attribute::has_many(/* same args */): AttributeRelationFactory
```

Typical arguments for `wp_postmeta`:

| Argument                | Value          |
|-------------------------|----------------|
| `$foreign_column`       | `'post_id'`    |
| `$foreign_attribute`    | `'meta_key'`   |
| `$foreign_value_column` | `'meta_value'` |

---

## Column configuration

### `ACA\DataSources\DataSource\Config\Columns`

Immutable builder for column configuration.

```php
Config\Columns::create(): self
$config->with_columns(array $columns): self        // Config\Column[]
$config->with_column(Config\Column $column): self
$config->with_label_resolver(ColumnLabelResolver $resolver): self
$config->with_identifier(Config\Identifier $identifier): self
```

Any column declared via `with_columns()` overrides the auto-detected type for
that column. Columns not declared still appear with default rendering.

### `ACA\DataSources\DataSource\ColumnLabelResolver\HumanReadableResolver`

Turns raw column names into Title Case labels (`comment_author_email` →
"Comment Author Email"). Plug into `Config\Columns::with_label_resolver()`.

```php
new HumanReadableResolver()
```

### `ACA\DataSources\Repository\Database\Table\Filter\Name`

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

### `ACA\DataSources\Repository\Database\Table\Resolver`

The underlying resolver used by `Facade\Table`. Useful when you want the raw
`Table` object without going through the facade.

```php
(new Resolver())->resolve(string $table, ?string $identifier = null): Table
```

---

## Column types

All column types live under `ACA\DataSources\DataSource\ColumnType`. Each type
exposes a static `::for($column_name, …)` method that returns a
`Config\Column` ready to drop into `Config\Columns::with_columns([...])`.

| Type                 | `for()` signature                                                                               | Purpose                                                                                             |
|----------------------|-------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------|
| `TextType`           | `for(string $name)`                                                                             | Plain text.                                                                                         |
| `NumberType`         | `for(string $name)`                                                                             | Numeric value.                                                                                      |
| `BooleanType`        | `for(string $name, ?ToggleOptions $options = null)`                                             | True/false toggle. Supply `ToggleOptions` to map non-boolean stored values (`open`/`closed`, etc.). |
| `DateTimeType`       | `for(string $name, ?string $date_save_format = null)`                                           | Date/time. `$date_save_format` describes how the value is stored (e.g. `'Y-m-d H:i:s'`).            |
| `EmailType`          | `for(string $name)`                                                                             | `mailto:` link.                                                                                     |
| `UrlType`            | `for(string $name)`                                                                             | Clickable URL.                                                                                      |
| `ImageType`          | `for(string $name)`                                                                             | Renders the stored value as an image.                                                               |
| `ColorType`          | `for(string $name)`                                                                             | Colour swatch.                                                                                      |
| `SelectColumnType`   | `for(string $name, array $options = [], bool $is_multiple = false, bool $lock_options = false)` | Value-to-label map; `$options` is `['stored' => 'Label', …]`.                                       |
| `WordPressPostType`  | `for(string $name)`                                                                             | Links the stored post ID to the edit screen.                                                        |
| `WordPressUserType`  | `for(string $name)`                                                                             | Renders the referenced user with avatar.                                                            |
| `WordPressMediaType` | `for(string $name)`                                                                             | Renders the referenced attachment.                                                                  |

Example:

```php
Config\Columns::create()->with_columns([
    ColumnType\TextType::for('post_content')->with_label('Content'),
    ColumnType\WordPressUserType::for('post_author')->with_label('Author'),
    ColumnType\DateTimeType::for('post_date', 'Y-m-d H:i:s')->with_label('Publish Date'),
    ColumnType\BooleanType::for('comment_status', ToggleOptions::create_from_values('closed', 'open'))
        ->with_label('Comment Status'),
]);
```