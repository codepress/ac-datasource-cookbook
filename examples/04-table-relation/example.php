<?php
/**
 * Recipe: Table-to-Table Relation (has_one).
 * See readme.md for the walkthrough.
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
    // The foreign Data Source must be registered before it can be referenced in a relation.
    // We register the related Post table with some basic columns (not all)
    $post_columns = Config\Columns::create()
        ->with_column(ColumnType\TextType::for('post_title'))
        ->with_column(ColumnType\TextType::for('post_content'))
        ->with_label_resolver(new HumanReadableResolver());

    $post_table = Facade\Table::from('wp_posts')
        ->filter(new Filter\Name(['ID', 'post_title', 'post_content']));

    $post_data_source = new ACA\DataSources\DataSource(
        new DataSourceId('related_posts'),
        $post_table,
        $post_columns
    );

    $registry->register(new Entry($post_data_source));

    $posts = new DataSource(
        new DataSourceId('comments_with_related_posts'),
        Facade\Table::from('wp_comments'),
        Config\Columns::create()->with_label_resolver(new HumanReadableResolver()),
        new Facade\Relations([
            // Joins on wp_posts.ID to wp_comments.comment_post_ID (the local primary key).
            Facade\Relation\Table::has_one($post_data_source, 'ID', 'comment_post_ID'),
        ])
    );

    $registry->register(
        Entry::create($posts)->set_submenu('04. Comments with related Post', 'ac-ds-cookbook')
    );
});
