<?php

/**
 * Library of interface functions and constants.
 *
 * @package     local_ultimate_market
 * @copyright   2021 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */

use local_ultimate_market\local\entities\order;
use local_ultimate_market\local\exceptions\product_not_purchased;

defined('MOODLE_INTERNAL') || die();

/**
 * Serves the files from the local_ultimate_market file areas.
 *
 * @package     local_ultimate_market
 * @category    files
 *
 * @param stdClass $course The course object.
 * @param stdClass $cm The course module object.
 * @param stdClass $context The local_ultimate_market's context.
 * @param string $filearea The name of the file area.
 * @param array $args Extra arguments (itemid, path).
 * @param bool $forcedownload Whether or not force download.
 * @param array $options Additional options affecting the file serving.
 */
function local_ultimate_market_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, $options = array()) {
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }

    require_login($course, false, $cm);

    $itemid = (int)array_shift($args);
    if ($itemid == 0) {
        return false;
    }

    if ($filearea == 'attachment') {
        $orderentity = new order();

        if (!$orderentity->user_purchased_product($itemid)) {
            throw new product_not_purchased('You have not purchased this product');
        }
    }

    $relativepath = implode('/', $args);

    $fullpath = "/{$context->id}/local_ultimate_market/$filearea/$itemid/$relativepath";

    $fs = get_file_storage();
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        return false;
    }

    send_stored_file($file, 0, 0, $forcedownload, $options);
}

function local_ultimate_market_extend_navigation_course($navigation, $course, $context) {
    if (has_capability('moodle/course:update', $context)) {
        $url = new moodle_url('/local/ultimate_market/courseorders.php', ['id' => $course->id]);

        $navigation->add(
            get_string('ultimate_marketorders', 'local_ultimate_market'),
            $url,
            navigation_node::TYPE_CUSTOM,
            null,
            'evokeultimate_marketorders',
            new pix_icon('i/course', '')
        );
    }
}
