# Registration

[Back to API reference](./api-reference.md)

The hook, core model, and shortcut facades for getting a Data Source
into the admin.

## The hook

### `acp/data-sources/register`

Fires once, after Admin Columns Pro has booted. The only place where
Data Sources should be registered.

```php
add_action('acp/data-sources/register', function (DataSourceRegistry $registry) {
    // register Data Sources here
});
```

## Core model

### `ACA\DataSources\DataSource`

Model of one browsable table. Combines an identifier, a table, optional
column configuration, and optional relations.

```php
new DataSource(
    DataSourceId $id,
    Repository\Database\Table $table,
    ?Config\Columns $columns = null,
    ?RelationFactoryCollection $relations = null
)
```

See: [Tables](./tables.md), [Columns](./columns.md), [Relations](./relations.md).

### `ACA\DataSources\Type\DataSourceId`

Value object wrapping the unique string identifier of a Data Source. The
identifier must match `^[a-z][a-z0-9]*(_[a-z0-9]+)*$` (lowercase
snake_case starting with a letter).

```php
new DataSourceId('cookbook_users')
```

### `ACA\DataSources\DataSourceRegistry`

The registry passed into `acp/data-sources/register`. Call `register()`
with an `Entry` to add a Data Source.

```php
$registry->register(Entry $entry): void
```

### `ACA\DataSources\DataSourceRegistry\Entry`

Wraps a `DataSource` with admin-menu metadata before registration.

```php
Entry::create(DataSource $data_source): self
$entry->set_menu(string $title, ?string $menu_title = null, ?string $icon = null, ?int $position = null): self
$entry->set_submenu(string $title, string $parent_slug, ?string $menu_title = null, ?int $position = null): self
$entry->set_group(AC\Type\Group $group): self
$entry->set_capabilities(Capabilities $capabilities): self
```

`set_menu` places the Data Source under its own top-level item.
`set_submenu` places it under an existing admin menu (identified by its
slug).

## Shortcut facades

`Facade\*` classes are static helpers that wrap the core constructors.
They accept plain strings and handle table resolution for you. Prefer
them when you do not need to customise the object after creation.

### `ACA\DataSources\Facade\DataSource`

Builds a `DataSource` from a table name in one call.

```php
Facade\DataSource::from(
    string $table,
    string $data_source_id,
    ?Config\Columns $config = null,
    ?RelationFactoryCollection $relations = null
): DataSource
```

### `ACA\DataSources\Facade\Entry`

Builds a `DataSourceRegistry\Entry` directly from a table name. A
one-call shortcut for simple Data Sources.

```php
Facade\Entry::from(
    string $table,
    string $data_source_id,
    ?Config\Columns $config = null,
    ?RelationFactoryCollection $relations = null
): DataSourceRegistry\Entry
```
