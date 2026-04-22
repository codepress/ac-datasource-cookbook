<?php
/**
 * Recipe 01 — Super Simple Data Source
 * =============================================================================
 * The absolute minimum required to turn any database table into an Admin
 * Columns-powered overview page. This recipe registers the `wp_users` table
 * with no custom configuration at all. Admin Columns will:
 *   - Auto-detect every column from the table schema.
 *   - Generate reasonable default column types from the SQL column types.
 *   - Generate default labels from the column names.
 * Demonstrates
 * -----------------------------------------------------------------------------
 *   - The `acp/data-sources/register` action (the single entry point for
 *     adding Data Sources).
 *   - The `Facade\Table::from()` helper (wraps table resolution).
 *   - Creating a `DataSource` instance with only an ID and a table.
 *   - Registering an `Entry` with `set_submenu()` so the page appears in the
 *     WordPress admin.
 * Key takeaway
 * -----------------------------------------------------------------------------
 * If a table exists in the database, you can make it browsable in under ten
 * lines of code.
 */

declare(strict_types=1);

use ACA\DataSources\DataSource;
use ACA\DataSources\DataSourceRegistry;
use ACA\DataSources\DataSourceRegistry\Entry;
use ACA\DataSources\Facade;
use ACA\DataSources\Type\DataSourceId;

add_action('acp/data-sources/register', static function (DataSourceRegistry $registry): void {
    /*
     * Step 1 — Build the Data Source.
     *
     * `DataSourceId` is a small value object. Its string value must be unique
     * across every registered Data Source; it is used in URLs and in the
     * database to identify saved column configurations.
     *
     * `Facade\Table::from('wp_users')` resolves the real table (taking the
     * site's table prefix into account) and returns a `Repository\Database\Table`.
     */
    $data_source = new DataSource(
        new DataSourceId('cookbook_users'),
        Facade\Table::from('wp_users')
    );

    /*
     * Step 2 — Register it.
     *
     * `Entry::create()` wraps the Data Source with UI metadata (menu position,
     * capabilities, grouping). Here we attach it as a submenu of the
     * "DS Cookbook" top-level menu that bootstrap.php created.
     */
    $registry->register(
        Entry::create($data_source)->set_submenu('01 — Super Simple', 'ac-ds-cookbook')
    );
});
