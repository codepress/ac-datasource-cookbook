<?php
/**
 * Example: WooCommerce Orders with Relations.
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
use ACA\DataSources\Type\DataSourceId;
use ACP\Sql\Alias;

add_action('acp/data-sources/register', static function (DataSourceRegistry $registry): void {
    // Only load when WooCommerce is active. HPOS must also be enabled for the
    // `wp_wc_orders` table to exist (WooCommerce → Settings → Advanced → Features).
    if ( ! class_exists('WooCommerce')) {
        return;
    }

    // Step 1: Order meta (key/value table). No custom columns needed: the
    // Attribute relation exposes a single configurable column where the user
    // picks which meta_key to show.
    $orders_meta = Facade\DataSource::from('wp_wc_orders_meta', 'wc_orders_meta');
    $registry->register(new Entry($orders_meta));

    // Step 2: Order stats (one analytics row per order).
    $order_stats = Facade\DataSource::from(
        'wp_wc_order_stats',
        'wc_order_stats',
        Config\Columns::create()
            ->with_column(ColumnType\WordPressUserType::for('customer_id')->with_label('Customer'))
            ->with_label_resolver(new HumanReadableResolver())
    );
    $registry->register(new Entry($order_stats));

    // Step 3: Order product lookup (one row per line item; many rows per order).
    // This table has a composite primary key (order_item_id, order_id), which
    // the auto-detection cannot resolve. We build the Data Source directly and
    // pass `order_item_id` as the identifier. `Facade\DataSource::from()` does
    // not support this override.
    $order_products = new DataSource(
        new DataSourceId('wc_order_products'),
        Facade\Table::from('wp_wc_order_product_lookup', 'order_item_id'),
        Config\Columns::create()
            ->with_column(ColumnType\WordPressPostType::for('product_id')->with_label('Product'))
            ->with_column(ColumnType\WordPressUserType::for('customer_id')->with_label('Customer'))
            ->with_label_resolver(new HumanReadableResolver())
    );
    $registry->register(new Entry($order_products));

    // Step 4: Register the primary Orders table with all three relations attached.
    $orders = new DataSource(
        new DataSourceId('wc_orders'),
        Facade\Table::from('wp_wc_orders'),
        Config\Columns::create()
            ->with_column(ColumnType\WordPressUserType::for('customer_id')->with_label('Customer'))
            ->with_column(ColumnType\EmailType::for('billing_email')->with_label('Billing Email'))
            ->with_label_resolver(new HumanReadableResolver()),
        new Facade\Relations([
            // Table has_one: exactly one stats row per order (join on orders.id = stats.order_id).
            Facade\Relation\Table::has_one($order_stats, 'order_id', 'id', new Alias('wc_stats')),

            // Table has_many: many line-item rows per order. Values get aggregated per order.
            Facade\Relation\Table::has_many($order_products, 'order_id', 'id', new Alias('wc_products')),

            // Attribute has_one: single configurable column for picking an order meta key.
            Facade\Relation\Attribute::has_one(
                $orders_meta,
                'order_id',
                'Order Meta',
                'meta_key',
                'meta_value'
            ),
        ])
    );

    $registry->register(
        Entry::create($orders)->set_submenu('05. WooCommerce Orders', 'ac-ds-cookbook')
    );
});
