<?php
/**
 * Recipe: Defined Columns & Table Filtering.
 * See readme.md for the walkthrough.
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
    $columns = Config\Columns::create()
        ->with_columns([
            ColumnType\TextType::for('post_content')
                ->with_label('Content'),
            ColumnType\WordPressUserType::for('post_author')
                ->with_label('Author'),
            ColumnType\DateTimeType::for('post_date', 'Y-m-d H:i:s')
                ->with_label('Publish Date'),
            // `comment_status` is stored as "open"/"closed"; map to a boolean toggle.
            ColumnType\BooleanType::for('comment_status', ToggleOptions::create_from_values('closed', 'open'))
                ->with_label('Comment Status'),
        ])
        ->with_label_resolver(new HumanReadableResolver());

    $table = Facade\Table::from('wp_posts')
        ->filter(new Name(['ID', 'post_content', 'post_author', 'post_date', 'comment_status']));

    $data_source = new DataSource(
        new DataSourceId('example_posts_defined'),
        $table,
        $columns
    );

    $registry->register(
        Entry::create($data_source)->set_submenu('03. Defined Columns', 'ac-ds-cookbook')
    );
});
