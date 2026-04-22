# API reference

Reference for the classes and helpers used in the examples, grouped by
topic.

## Topics

- [Registration](./registration.md): the `acp/data-sources/register`
  hook, `DataSource`, `DataSourceId`, `DataSourceRegistry`, `Entry`,
  and the `Facade\DataSource` / `Facade\Entry` shortcuts.
- [Tables](./tables.md): resolving a database table and filtering which
  columns it exposes (`Facade\Table`, `Resolver`, `Filter\Name`).
- [Columns](./columns.md): configuring columns (`Config\Columns`),
  label resolvers, column types (`TextType`, `DateTimeType`, ...),
  and `ToggleOptions`.
- [Relations](./relations.md): joining two Data Sources
  (`Facade\Relation\Table`, `Facade\Relation\Attribute`,
  `Facade\Relations`).

## Conventions

Methods that return `self` are immutable. They return a cloned instance
with the change applied.
