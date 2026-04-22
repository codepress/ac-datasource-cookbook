# Relations

[Back to API reference](./api-reference.md)

Joins between Data Sources. A relation attaches columns from a second
table onto a primary Data Source. The foreign Data Source must itself
be registered.

## `ACA\DataSources\Facade\Relations`

Groups one or more relation factories. Pass to the `$relations`
argument of `DataSource` or a shortcut facade.

```php
new Facade\Relations([
    Facade\Relation\Table::has_one(...),
    Facade\Relation\Attribute::has_one(...),
])
```

## `ACA\DataSources\Facade\Relation\Table`

Joins two Data Sources on a foreign-key column. Use when the foreign
table has one row per related entity.

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

Joins a vertical key/value table (postmeta-style) and pivots each
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
