# Column types

All column types live under `ACA\DataSources\DataSource\ColumnType`. Each
type exposes a static `::for($column_name, …)` method that returns a
`Config\Column` ready to drop into `Config\Columns::with_columns([...])`.

## Available types

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

## Example

```php
Config\Columns::create()->with_columns([
    ColumnType\TextType::for('post_content')->with_label('Content'),
    ColumnType\WordPressUserType::for('post_author')->with_label('Author'),
    ColumnType\DateTimeType::for('post_date', 'Y-m-d H:i:s')->with_label('Publish Date'),
    ColumnType\BooleanType::for('comment_status', ToggleOptions::create_from_values('closed', 'open'))
        ->with_label('Comment Status'),
]);
```

!!! tip "Customising labels"
    Every `Config\Column` returned by a `::for()` call supports
    `->with_label('My Label')` to override the auto-generated heading.
