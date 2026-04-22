# Free-core helpers

Utilities that ship with the free Admin Columns plugin (`AC\` namespace)
and are used from the cookbook recipes.

## `AC\Type\ToggleOptions`

Describes how a boolean column's stored values map to the on/off state
used by the UI.

```php
ToggleOptions::create_from_values(string $disabled_value = '0', string $enabled_value = '1'): self
ToggleOptions::create_from_array(array $options): self    // ['stored_off' => 'Off Label', 'stored_on' => 'On Label']
```

The first argument is the value treated as "off"; the second is the value
treated as "on".

### Example

WordPress stores `comment_status` as the strings `'open'` and `'closed'`.
The following maps those values onto a boolean toggle:

```php
ColumnType\BooleanType::for(
    'comment_status',
    ToggleOptions::create_from_values('closed', 'open')
)->with_label('Comment Status');
```
