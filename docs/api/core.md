# Core model

The plain classes underneath the facades. Most recipes build Data Sources
through the [facades](facades.md), but they ultimately reduce to an
instance of each class below.

## `ACA\DataSources\DataSource`

The in-memory model of one browsable table. Combines an identifier, a
table, optional column configuration, and optional relations to other
Data Sources.

```php
new DataSource(
    DataSourceId $id,
    Repository\Database\Table $table,
    ?Config\Columns $columns = null,
    ?RelationFactoryCollection $relations = null
)
```

## `ACA\DataSources\Type\DataSourceId`

Value object that wraps the unique string identifier of a Data Source. The
identifier must match `^[a-z][a-z0-9]*(_[a-z0-9]+)*$` — lowercase
snake_case, starting with a letter.

```php
new DataSourceId('cookbook_users')
```

The identifier is used in URLs and in the database to identify saved
column configurations, so it should be stable across releases of your
code.

## `ACA\DataSources\DataSourceRegistry`

The registry passed into the [`acp/data-sources/register`](hook.md) hook.
Call `register()` with an `Entry` to add a Data Source.

```php
$registry->register(Entry $entry): void
```

## `ACA\DataSources\DataSourceRegistry\Entry`

Wraps a `DataSource` with admin-UI metadata (menu placement, capabilities,
grouping) before registration.

```php
Entry::create(DataSource $data_source): self

$entry->set_menu(string $title, ?string $menu_title = null, ?string $icon = null, ?int $position = null): self
$entry->set_submenu(string $title, string $parent_slug, ?string $menu_title = null, ?int $position = null): self
$entry->set_group(AC\Type\Group $group): self
$entry->set_capabilities(Capabilities $capabilities): self
```

Use `set_menu()` for a top-level WordPress admin menu, `set_submenu()` to
place the page underneath an existing menu (for example the cookbook's
own `ac-ds-cookbook` parent).
