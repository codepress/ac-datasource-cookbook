<?php
/**
 * Recipe 02 — Human-Readable Labels & Typed Columns
 * =============================================================================
 *
 * Two small improvements over Recipe 01:
 *
 *   1. A `HumanReadableResolver` is used as the label resolver. It turns raw
 *      column names like `comment_post_ID` into friendly headings such as
 *      "Comment Post Id" without having to label each column individually.
 *   2. A handful of columns are explicitly typed. Typed columns render with
 *      richer output (links, avatars, thumbnails) instead of the raw database
 *      value.
 *
 * Demonstrates
 * -----------------------------------------------------------------------------
 *   - `Config\Columns::create()` — the builder for column configuration.
 *   - `->with_label_resolver()` — controls how column labels are derived.
 *   - `->with_columns([...])` — overrides a subset of columns with typed
 *     variants; the remaining columns still get default rendering.
 *   - `ColumnType\WordPressPostType` and `ColumnType\WordPressUserType` —
 *     built-in column types that render linked post/user references.
 *   - `Repository\Database\Table\Resolver` — the same thing `Facade\Table`
 *     uses internally, shown here so you can see there is no magic.
 *
 * Key takeaway
 * -----------------------------------------------------------------------------
 * You do not need to configure every column. Type only the ones that benefit
 * from richer rendering; let the label resolver handle the rest.
 */

declare(strict_types=1);

use ACA\DataSources\DataSource;
use ACA\DataSources\DataSource\ColumnLabelResolver\HumanReadableResolver;
use ACA\DataSources\DataSource\ColumnType;
use ACA\DataSources\DataSource\Config;
use ACA\DataSources\DataSourceRegistry;
use ACA\DataSources\DataSourceRegistry\Entry;
use ACA\DataSources\Repository\Database\Table\Resolver;
use ACA\DataSources\Type\DataSourceId;

add_action('acp/data-sources/register', static function (DataSourceRegistry $registry): void {
    /*
     * Resolve the table without using the `Facade\Table` helper, to show
     * what the Facade does under the hood. `Resolver::resolve()` applies the
     * table prefix and returns a `Repository\Database\Table` instance.
     */
    $table = (new Resolver())->resolve('wp_comments');

    /*
     * Explicitly typed columns. Any column not listed here still appears in
     * the table with its default type derived from the SQL schema.
     *
     * - `WordPressPostType::for('comment_post_ID')` renders the referenced
     *   post title with a link to the edit screen.
     * - `WordPressUserType::for('user_id')` renders the user's display name
     *   with an avatar.
     */
    $columns = [
        ColumnType\WordPressPostType::for('comment_post_ID')->with_label('Post'),
        ColumnType\WordPressUserType::for('user_id')->with_label('User'),
    ];

    /*
     * Assemble the column configuration.
     *
     * `HumanReadableResolver` formats any column without an explicit label
     * (e.g. `comment_author_email` → "Comment Author Email").
     */
    $config = Config\Columns::create()
        ->with_label_resolver(new HumanReadableResolver())
        ->with_columns($columns);

    $data_source = new DataSource(
        new DataSourceId('cookbook_comments'),
        $table,
        $config
    );

    $registry->register(
        Entry::create($data_source)->set_submenu('02 — Human Readable', 'ac-ds-cookbook')
    );
});
