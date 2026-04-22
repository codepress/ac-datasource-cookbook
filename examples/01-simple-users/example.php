<?php
/**
 * Recipe: Super Simple Data Source.
 * See readme.md for the walkthrough.
 */

declare(strict_types=1);

use ACA\DataSources\DataSource;
use ACA\DataSources\DataSourceRegistry;
use ACA\DataSources\DataSourceRegistry\Entry;
use ACA\DataSources\Facade;
use ACA\DataSources\Type\DataSourceId;

add_action('acp/data-sources/register', static function (DataSourceRegistry $registry): void {
    $data_source = new DataSource(
        new DataSourceId('cookbook_users'),
        Facade\Table::from('wp_users')
    );

    $registry->register(
        Entry::create($data_source)
            ->set_submenu('01. Simple Users', 'ac-ds-cookbook')
    );

    // Or use this if you want a main menu item
    //    $registry->register(
    //        Entry::create($data_source)
    //            ->set_menu(
    //                'Simple Users',
    //                null,
    //                'dashicons-book-alt'
    //            )
    //    );
});
