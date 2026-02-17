<?php

/**
 * Configure course badges.
 *
 * @package     mod_evokeportfolio
 * @copyright   2021 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */

require(__DIR__.'/../../config.php');

$productid = required_param('id', PARAM_INT);
$courseid = required_param('courseid', PARAM_INT);

require_login($courseid);

$context = context_course::instance($courseid);

$PAGE->set_context($context);

try {
    $seller = new \local_ultimate_market\util\seller();

    $seller->sell($productid, $courseid);
} catch (\local_ultimate_market\local\exceptions\order_limitperuser $e) {
    redirect($e->link, \core\notification::warning($e->getMessage()));
}
