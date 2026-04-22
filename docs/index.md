# AC Datasource Cookbook

A collection of annotated code examples that show how to register custom
**Data Sources** for [Admin Columns Pro](https://www.admincolumns.com/).

Each recipe is a self-contained PHP file under
[`examples/`](https://github.com/codepress/ac-datasource-cookbook/tree/main/examples)
that you can read top to bottom. The recipes progress from the simplest
possible registration to more advanced compositions with related tables.

## What you will learn

- How a Data Source turns any database table into an Admin Columns-powered
  overview page.
- How to configure column types, labels, and filtering on the output.
- How to relate two Data Sources — classic table joins and key/value
  attribute relations.

## Where to start

<div class="grid cards" markdown>

-   :material-rocket-launch:{ .lg .middle } **Getting started**

    ---

    Install the plugin, enable recipes, and see them appear in WordPress.

    [:octicons-arrow-right-24: Installation & usage](getting-started.md)

-   :material-book-open-page-variant:{ .lg .middle } **Recipes**

    ---

    Four progressive examples, from the absolute minimum to a table join.

    [:octicons-arrow-right-24: Browse recipes](recipes/index.md)

-   :material-api:{ .lg .middle } **API reference**

    ---

    Every class, facade, column type, and helper used in the recipes.

    [:octicons-arrow-right-24: Open reference](api/index.md)

</div>

## Requirements

- WordPress 5.9 or later
- PHP 7.4 or later
- Admin Columns Pro
- The **Data Sources** addon (bundled with ACP)
