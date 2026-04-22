# Facades

The `Facade\*` classes are thin, static-method helpers that wrap the
[core constructors](core.md). They accept plain strings and handle table
resolution for you — prefer them over building core objects manually.

## `ACA\DataSources\Facade\Table`

Resolves a database table by name and applies the current site's table
prefix automatically.

```php
Facade\Table::from(string $table, ?string $identifier = null): Repository\Database\Table
```

The returned `Table` exposes a `->filter()` method for hiding or keeping
specific columns — see
[`Filter\Name`](configuration.md#acadatasourcesrepositorydatabasetablefiltername).

## `ACA\DataSources\Facade\DataSource`

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

## `ACA\DataSources\Facade\Entry`

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

## `ACA\DataSources\Facade\Relations`

A typed container for one or more relation factories. Pass the array of
relations you want to attach to a Data Source.

```php
new Facade\Relations([
    Facade\Relation\Table::has_one(...),
    Facade\Relation\Attribute::has_one(...),
])
```

## `ACA\DataSources\Facade\Relation\Table`

Joins two Data Sources on a foreign-key column. Use when the foreign
table has wide rows (one row per related entity).

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

## `ACA\DataSources\Facade\Relation\Attribute`

Joins to a vertical key/value table (postmeta-style) and pivots each
distinct key into its own column on the parent Data Source.

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
