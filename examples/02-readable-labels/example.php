<?php
/**
 * Recipe: Human-Readable Labels & Typed Columns.
 * See readme.md for the walkthrough.
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
    // `Resolver` is what `Facade\Table` uses internally, shown here without the facade.
    $table = (new Resolver())->resolve('wp_comments');

    // Define custom column types for related columns
    $columns = [
        ColumnType\WordPressPostType::for('comment_post_ID')->with_label('Post'),
        ColumnType\WordPressUserType::for('user_id')->with_label('User'),
    ];

    $config = Config\Columns::create()
        // This line transforms the table labels to Readable labels
        ->with_label_resolver(new HumanReadableResolver())
        ->with_columns($columns);

    $data_source = new DataSource(
        new DataSourceId('example_comments'),
        $table,
        $config
    );

    $registry->register(
        Entry::create($data_source)
            ->set_submenu(
                '02. Comments with readable labels',
                'ac-ds-cookbook',
                '02. Readable Column Labels'
            )
    );
});
