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
    // Register the foreign Data Source first, without a menu page. This is
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

    // Primary Data Source: comments. Each comment row references one post
    // via `comment_post_ID` (the local foreign key to `wp_posts.ID`).
    $comments = new DataSource(
        new DataSourceId('comments_with_related_posts'),
        Facade\Table::from('wp_comments'),
        Config\Columns::create()->with_label_resolver(new HumanReadableResolver()),
        new Facade\Relations([
            // has_one(foreign_ds, foreign_column, local_column)
            Facade\Relation\Table::has_one($post_data_source, 'ID', 'comment_post_ID'),
        ])
    );

    $registry->register(
        Entry::create($comments)->set_submenu('04. Comments with related Post', 'ac-ds-cookbook')
    );
});
