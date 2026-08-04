<?php

namespace local_ultimate_market\util;

defined('MOODLE_INTERNAL') || die();

use local_ultimate\util\coin;
use local_ultimate\util\coinledger;
use local_ultimate_market\local\entities\order;
use local_ultimate_market\local\exceptions\not_enrolled;
use local_ultimate_market\local\exceptions\order_limitperuser;
use local_ultimate_market\local\entities\product;
use local_ultimate_market\local\exceptions\product_disabled;
use local_ultimate_market\local\exceptions\product_outofstock;
use moodle_url;

/**
 * Evocoin utility class.
 *
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */
class seller {
    public function sell($id, $courseid, $userid = null) {
        global $DB, $CFG, $USER;

        if (!$userid) {
            $userid = $USER->id;
        }

        $productentity = new product();

        $product = $productentity->find($id);

        if ($product->enabled == product::DISABLED) {
            throw new product_disabled('product_disabled', $courseid);
        }

        if (!$productentity->instock($product)) {
            throw new product_outofstock('product_outofstock', $courseid);
        }

        if ($product->courseid) {
            $context = \context_course::instance($courseid);

            if (!is_enrolled($context, $userid)) {
                throw new not_enrolled('you_are_not_enrolled_on_course', $courseid);
            }
        }

        if ($product->limitperuser != null) {
            $orderentity = new order();

            $userpurchases = $orderentity->count_user_product_purchases($product->id, $userid);

            if ($product->limitperuser <= $userpurchases) {
                throw new order_limitperuser('order_limitperuser', $courseid);
            }
        }

        $url = new moodle_url('/local/ultimate_market/index.php', ['id' => $courseid]);

        $coinutil = new coin();

        $usercoins = $coinutil->get_user_coins($userid);

        if (!$usercoins || $product->price > $usercoins) {
            redirect($url, get_string('nocoinstobuy', 'local_ultimate_market'), null, \core\output\notification::NOTIFY_WARNING);
        }

        try {
            $order = new \stdClass();
            $order->productid = $product->id;
            $order->userid = $userid;
            $order->price = $product->price;
            $order->status = 'delivered';
            $order->timecreated = time();
            $order->timemodified = time();

            $orderid = $DB->insert_record('ultimate_market_orders', $order);

            $productentity->decrease_stock($product, 1);

            $coinledger = new coinledger();
            $coinledger->add_entry($courseid, $userid, 'local_ultimate_market', 'order_product', $orderid, $product->price, 'out');

            $coin = new coin();
            $coin->decrease_coins($userid, $product->price);

            redirect($url, get_string('buy_success', 'local_ultimate_market'), null, \core\output\notification::NOTIFY_SUCCESS);
        } catch (\Exception $e) {
            if ($CFG->debugdisplay) {
                throw $e;
            }

            redirect($url, get_string('errorbuy', 'local_ultimate_market'), null, \core\output\notification::NOTIFY_ERROR);
        }
    }
}
