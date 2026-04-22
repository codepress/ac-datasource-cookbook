# The hook

## `acp/data-sources/register`

Fires once, after Admin Columns Pro has booted. This is the only place where
Data Sources should be registered.

```php
add_action('acp/data-sources/register', function (DataSourceRegistry $registry) {
    // register Data Sources here
});
```

The registry passed to the callback is the single instance used by the
Data Sources addon; anything you `->register()` on it becomes available in
the Admin Columns table screens that the addon exposes.
