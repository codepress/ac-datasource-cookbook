<?php
/**
 * Recipe: Table-to-Table Relation (has_one).
 * See readme.md for the walkthrough.
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
    // The foreign Data Source must be registered before it can be referenced in a relation.
    $comments = Facade\DataSource::from('wp_comments', 'cookbook_rel_comments');
    $registry->register(new Entry($comments));

    $config = Config\Columns::create()->with_label_resolver(new HumanReadableResolver());

    $table = Facade\Table::from('wp_posts')
        ->filter(new Name(['post_date_gmt'], Name::EXCLUDE));

    $posts = new DataSource(
        new DataSourceId('cookbook_posts_with_comment'),
        $table,
        $config,
        new Facade\Relations([
            // Joins on wp_comments.comment_post_ID to wp_posts.ID (the local primary key).
            Facade\Relation\Table::has_one($comments, 'comment_post_ID'),
        ])
    );

    $registry->register(
        Entry::create($posts)->set_submenu('04. Post + Comment', 'ac-ds-cookbook')
    );
});
