<?php
/**
 * Cookbook bootstrap.
 * This file controls which recipes are loaded. Comment out any `require` below
 * to disable that example. Each recipe is independent. You can enable just
 * one or all of them, in any combination.
 * All recipes register their Data Sources under the shared top-level admin
 * menu "DS Cookbook" so the WordPress sidebar stays tidy.
 */

declare(strict_types=1);

if ( ! defined('ABSPATH')) {
    exit;
}

/*
 * Register the top-level admin menu that all recipes attach to.
 *
 * We register an empty page here. Each recipe calls `set_submenu('…', 'ac-ds-cookbook')`
 * on its Entry so WordPress places the page underneath this parent.
 */
add_action('admin_menu', static function (): void {
    add_menu_page(
        'Datasources',
        'Datasources',
        'manage_options',
        'ac-ds-cookbook',
        '__return_empty_string',
        'dashicons-book-alt',
        25
    );
});

/*
 * Enable or disable recipes by (un)commenting the lines below.
 *
 * The recipes are ordered from simplest to most advanced. If you are new to
 * Data Sources, start at the top and work your way down.
 */
require __DIR__ . '/examples/01-simple-users/example.php';
require __DIR__ . '/examples/02-readable-labels/example.php';
require __DIR__ . '/examples/03-defined-columns/example.php';
require __DIR__ . '/examples/04-table-relation/example.php';

/*
 * Examples that depend on a third-party plugin guard themselves with a
 * `class_exists()` / `function_exists()` check at the top of the file, so
 * they no-op silently when the plugin is inactive.
 */
require __DIR__ . '/examples/05-wc-orders/example.php';
