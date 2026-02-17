<?php

namespace local_ultimate_market\local\exceptions;

use moodle_url;
use moodle_exception;

/**
 * Product out of stock exception class.
 *
 * @package     local_ultimate_market
 * @copyright   2023 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */
class order_limitperuser extends moodle_exception {
    public function __construct($errorcode, $courseid) {
        $url = new moodle_url('/local/ultimate_market/index.php', ['id' => $courseid]);

        parent::__construct($errorcode, 'local_ultimate_market', $url, null, null);
    }
}
