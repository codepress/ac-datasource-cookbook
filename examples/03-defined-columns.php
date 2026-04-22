<?php
/**
 * Recipe 03 — Defined Columns & Table Filtering
 * =============================================================================
 *
 * Where recipes 01 and 02 let Admin Columns auto-detect columns, this recipe
 * takes more control:
 *
 *   - Each exposed column is declared up front with an explicit type.
 *   - Specific columns can be excluded from the listing entirely.
 *
 * Demonstrates
 * -----------------------------------------------------------------------------
 *   - `ColumnType\TextType`, `DateTimeType`, `BooleanType`, `WordPressUserType`
 *     — four of the most common built-in column types.
 *   - Customising date formats via `DateTimeType::for($column, $format)`.
 *   - `ToggleOptions::create_from_values()` — maps stored values to boolean
 *     display (e.g. `"closed"/"open"` → false/true toggle).
 *   - `Facade\Table::from(...)->filter(new Name([...], Name::EXCLUDE))` —
 *     hides columns from the table before they reach the UI.
 *
 * Key takeaway
 * -----------------------------------------------------------------------------
 * Typing columns explicitly gives you control over rendering, sorting, filtering
 * and editing behaviour. Combine it with a table filter to hide columns you
 * don't want to expose (e.g. internal timestamps, duplicate GMT fields).
 */

declare(strict_types=1);

use AC\Type\ToggleOptions;
use ACA\DataSources\DataSource;
use ACA\DataSources\DataSource\ColumnLabelResolver\HumanReadableResolver;
use ACA\DataSources\DataSource\ColumnType;
use ACA\DataSources\DataSource\Config;
use ACA\DataSources\DataSourceRegistry;
use ACA\DataSources\DataSourceRegistry\Entry;
use ACA\DataSources\Facade;
use ACA\DataSources\Repository\Database\Table\Filter\Name;
use ACA\DataSources\Type\DataSourceId;

add_action('acp/data-sources/register', static function (DataSourceRegistry $registry): void {
    /*
     * Build the column configuration. Every column declared here is a fully
     * typed column with its own label and renderer. Columns from the schema
     * that are NOT listed are still shown with default rendering unless the
     * table filter (below) excludes them.
     */
    $columns = Config\Columns::create()
        ->with_columns([
            ColumnType\TextType::for('post_content')
                ->with_label('Content'),
            ColumnType\WordPressUserType::for('post_author')
                ->with_label('Author'),
            ColumnType\DateTimeType::for('post_date', 'Y-m-d H:i:s')
                ->with_label('Publish Date'),
            // `ToggleOptions` maps stored string values to a boolean display.
            // WordPress stores `comment_status` as "open" or "closed"; here
            // "closed" is treated as false, "open" as true.
            ColumnType\BooleanType::for('comment_status', ToggleOptions::create_from_values('closed', 'open'))
                ->with_label('Comment Status'),
        ])
        ->with_label_resolver(new HumanReadableResolver());

    /*
     * Exclude the `post_date_gmt` column from the listing. It duplicates
     * `post_date` and clutters the UI. `Name::EXCLUDE` means "any column in
     * this list is hidden"; `Name::INCLUDE` would do the opposite.
     */
    $table = Facade\Table::from('wp_posts')
        ->filter(new Name(['post_date_gmt'], Name::EXCLUDE));

    $data_source = new DataSource(
        new DataSourceId('cookbook_posts_defined'),
        $table,
        $columns
    );

    $registry->register(
        Entry::create($data_source)->set_submenu('03 — Defined Columns', 'ac-ds-cookbook')
    );
});
