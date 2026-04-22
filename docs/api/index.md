# API Reference

A quick lookup of every class and helper that appears in the cookbook
recipes. Each entry lists the namespace, a short description, and the
signature you are most likely to use.

Methods that return `self` in the listings are immutable — they return a
cloned instance with the change applied.

## On this page set

<div class="grid cards" markdown>

-   :material-hook:{ .lg .middle } **[The hook](hook.md)**

    ---

    `acp/data-sources/register` — where every recipe starts.

-   :material-cube-outline:{ .lg .middle } **[Core model](core.md)**

    ---

    `DataSource`, `DataSourceId`, `DataSourceRegistry`, `Entry`.

-   :material-layers-outline:{ .lg .middle } **[Facades](facades.md)**

    ---

    Static helpers that wrap the core constructors.

-   :material-tune:{ .lg .middle } **[Column configuration](configuration.md)**

    ---

    `Config\Columns`, label resolvers, table filters.

-   :material-format-list-bulleted-type:{ .lg .middle } **[Column types](column-types.md)**

    ---

    Every built-in `ColumnType` and its `for()` signature.

-   :material-toolbox-outline:{ .lg .middle } **[Free-core helpers](helpers.md)**

    ---

    Utilities from the free `AC\` namespace used by recipes.

</div>
