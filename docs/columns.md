# Columns

[Back to API reference](./api-reference.md)

Configuring columns on a Data Source: the builder, label resolvers,
typed columns, and `ToggleOptions`.

## `ACA\DataSources\DataSource\Config\Columns`

Immutable builder for column configuration.

```php
Config\Columns::create(): self
$config->with_columns(array $columns): self        // Config\Column[]
$config->with_column(Config\Column $column): self
$config->with_label_resolver(ColumnLabelResolver $resolver): self
$config->with_identifier(Config\Identifier $identifier): self
```

Any column declared via `with_columns()` overrides the auto-detected
type for that column. Columns not declared still appear with default
rendering.

## Label resolvers

### `ACA\DataSources\DataSource\ColumnLabelResolver\HumanReadableResolver`

Turns raw column names into Title Case labels (`comment_author_email`
becomes "Comment Author Email"). Plug into
`Config\Columns::with_label_resolver()`.

```php
new HumanReadableResolver()
```

## Column types

All column types live under `ACA\DataSources\DataSource\ColumnType`.
Each type exposes a static `::for($column_name, …)` method that returns
a `Config\Column` ready to drop into `Config\Columns::with_columns([...])`.

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
| `SelectColumnType`   | `for(string $name, array $options = [], bool $is_multiple = false, bool $lock_options = false)` | Value-to-label map. `$options` is `['stored' => 'Label', …]`.                                       |
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

## `AC\Type\ToggleOptions`

Maps a pair of stored string values onto the boolean toggle that
`BooleanType` renders. First argument is the "off" value, second is the
"on" value.

```php
ToggleOptions::create_from_values(string $off_value, string $on_value): ToggleOptions
```
