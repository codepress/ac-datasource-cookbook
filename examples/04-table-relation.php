<?php
/**
 * Recipe 04 — Table-to-Table Relation (has_one)
 * =============================================================================
 *
 * Up until now each Data Source has been a single table. Real data models
 * usually have relationships. This recipe shows how to join a second table
 * into a Data Source so its columns become available alongside the primary
 * table's columns.
 *
 * The scenario: register `wp_posts` and add columns from the related
 * `wp_comments` table via a `has_one` relation (one post to one comment row
 * in the join — see the note at the bottom for `has_many`).
 *
 * Demonstrates
 * -----------------------------------------------------------------------------
 *   - Registering multiple Data Sources in a single callback.
 *   - `Facade\Relation\Table::has_one()` — joins two Data Sources on a foreign
 *     key column; both sides share the same row when queried.
 *   - `Facade\Relations` — the container that holds one or more relations for
 *     a Data Source.
 *   - Reusing a table filter to hide a column (see Recipe 03).
 *
 * Key takeaway
 * -----------------------------------------------------------------------------
 * A related Data Source must itself be a Data Source. Register the "foreign"
 * Data Source (here: comments) first, then reference it when building the
 * primary Data Source (posts).
 */

declare(strict_types=1);

use ACA\DataSources\DataSource;
use ACA\DataSources\DataSource\ColumnLabelResolver\HumanReadableResolver;
use ACA\DataSources\DataSource\Config;
use ACA\DataSources\DataSourceRegistry;
use ACA\DataSources\DataSourceRegistry\Entry;
use ACA\DataSources\Facade;
use ACA\DataSources\Repository\Database\Table\Filter\Name;
use ACA\DataSources\Type\DataSourceId;

add_action('acp/data-sources/register', static function (DataSourceRegistry $registry): void {
    /*
     * Step 1 — Declare the foreign Data Source.
     *
     * The comments Data Source must exist in the registry before any other
     * Data Source can relate to it. `Facade\DataSource::from()` is a shortcut
     * that builds a default DataSource from a table name.
     */
    $comments = Facade\DataSource::from('wp_comments', 'cookbook_rel_comments');
    $registry->register(new Entry($comments));

    /*
     * Step 2 — Build the primary table (posts).
     */
    $config = Config\Columns::create()->with_label_resolver(new HumanReadableResolver());

    $table = Facade\Table::from('wp_posts')
        ->filter(new Name(['post_date_gmt'], Name::EXCLUDE));

    /*
     * Step 3 — Wire up the relation.
     *
     * `has_one` arguments:
     *   - $foreign_data_source: the target Data Source (comments).
     *   - $foreign_column: the column on the FOREIGN table that links back to
     *     us — here `comment_post_ID` on wp_comments.
     *   - $local_column (optional): the matching column on OUR table. Defaults
     *     to the primary key (`ID` on wp_posts).
     *
     * The result: every post row can expose columns from its first matching
     * comment as if they were its own.
     */
    $posts = new DataSource(
        new DataSourceId('cookbook_posts_with_comment'),
        $table,
        $config,
        new Facade\Relations([
            Facade\Relation\Table::has_one($comments, 'comment_post_ID'),
        ])
    );

    $registry->register(
        Entry::create($posts)->set_submenu('04 — Post + Comment', 'ac-ds-cookbook')
    );

    /*
     * Note on `has_many`
     * -------------------------------------------------------------------------
     * Swap `Facade\Relation\Table::has_one(...)` for `::has_many(...)` when a
     * single primary row can match many foreign rows (e.g. one post has many
     * comments). The Data Sources addon will aggregate the values per row.
     */
});
