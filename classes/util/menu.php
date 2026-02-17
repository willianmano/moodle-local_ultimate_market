<?php

namespace local_ultimate_market\util;

defined('MOODLE_INTERNAL') || die();

use moodle_url;
use navigation_node;

/**
 * Admin menu utility class.
 *
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */
class menu {
    public static function fill_secondary_menu_with_admin_items() {
        global $PAGE;

        $secondary = $PAGE->secondarynav;

        $secondary->add(
            get_string('ultimate_market', 'local_ultimate_market'),
            new moodle_url('/local/ultimate_market/admin/index.php'),
            navigation_node::TYPE_CUSTOM
        );

        $secondary->add(
            get_string('orders', 'local_ultimate_market'),
            new moodle_url('/local/ultimate_market/admin/orders.php'),
            navigation_node::TYPE_CUSTOM
        );

        $secondary->add(
            get_string('products', 'local_ultimate_market'),
            new moodle_url('/local/ultimate_market/admin/products.php'),
            navigation_node::TYPE_CUSTOM
        );

        $secondary->add(
            get_string('categories', 'local_ultimate_market'),
            new moodle_url('/local/ultimate_market/admin/categories.php'),
            navigation_node::TYPE_CUSTOM
        );
    }
}