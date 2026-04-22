<?php
/**
 * Plugin Name:       AC Datasource Cookbook
 * Plugin URI:        https://www.admincolumns.com/
 * Description:       A collection of annotated code examples that demonstrate how to register custom Data Sources for Admin Columns Pro. Enable examples in bootstrap.php.
 * Version:           1.0.0
 * Requires at least: 5.9
 * Requires PHP:      7.4
 * Author:            Admin Columns
 * Author URI:        https://www.admincolumns.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 * -----------------------------------------------------------------------------
 * About this plugin
 * -----------------------------------------------------------------------------
 * The cookbook is a learning resource, not a production plugin. Every file under
 * /examples/ is a stand-alone recipe that registers a Data Source via the
 * `acp/data-sources/register` action. Each recipe is heavily commented so you
 * can read it top to bottom and understand which parts of the Data Sources API
 * it demonstrates.
 *
 * Requirements:
 *   - Admin Columns Pro
 *   - The Data Sources addon (bundled with ACP)
 *
 * Getting started:
 *   1. Activate this plugin.
 *   2. Open `bootstrap.php` and uncomment the examples you want to try.
 *   3. Visit the "DS Cookbook" menu in the WordPress admin to see the
 *      resulting tables.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/bootstrap.php';