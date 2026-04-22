<?php
/**
 * Example: Table-to-Table Relation (has_one).
 * See readme.md for the explanation.
 */

declare(strict_types=1);

use ACA\DataSources\DataSource;
use ACA\DataSources\DataSource\ColumnLabelResolver\HumanReadableResolver;
use ACA\DataSources\DataSource\ColumnType;
use ACA\DataSources\DataSource\Config;
use ACA\DataSources\DataSourceRegistry;
use ACA\DataSources\DataSourceRegistry\Entry;
use ACA\DataSources\Facade;
use ACA\DataSources\Repository\Database\Table\Filter;
use ACA\DataSources\Type\DataSourceId;

add_action('acp/data-sources/register', static function (DataSourceRegistry $registry): void {
    // Step 1: Register the foreign Data Source first, without a menu page. This is
    // required for its columns to be exposed via the relation below.
    $post_columns = Config\Columns::create()
        ->with_column(ColumnType\TextType::for('post_title'))
        ->with_column(ColumnType\TextType::for('post_content'))
        ->with_label_resolver(new HumanReadableResolver());

    $post_table = Facade\Table::from('wp_posts')
        ->filter(new Filter\Name(['ID', 'post_title', 'post_content']));

    $post_data_source = new DataSource(
        new DataSourceId('related_posts'),
        $post_table,
        $post_columns
    );

    $registry->register(new Entry($post_data_source));

    // Step 2: Register the comment meta table as a Data Source. Using the
    // `Facade\DataSource::from()` shortcut when no custom columns are needed.
    $comment_meta = Facade\DataSource::from('wp_commentmeta', 'related_comment_meta');

    $registry->register(new Entry($comment_meta));

    // Step 3: Register the primary table (Comments) and attach the other
    // Data Sources as relations. Each comment row references one post via
    // `comment_post_ID` (the local foreign key to `wp_posts.ID`).
    $comments = new DataSource(
        new DataSourceId('comments_with_related_posts'),
        Facade\Table::from('wp_comments'),
        Config\Columns::create()
            ->with_label_resolver(new HumanReadableResolver()),
        new Facade\Relations([
            // Table relation: join one row from wp_posts per comment.
            Facade\Relation\Table::has_one($post_data_source, 'ID', 'comment_post_ID'),

            // Attribute relation: exposes a configurable column where the
            // user picks which `meta_key` to display. Can be added multiple
            // times to show different keys (like the Custom Field column).
            Facade\Relation\Attribute::has_one(
                $comment_meta,
                'comment_id',
                'Comment Meta',
                'meta_key',
                'meta_value'
            ),
        ])
    );

    $registry->register(
        Entry::create($comments)->set_submenu('04. Comments with related Post', 'ac-ds-cookbook')
    );
});
