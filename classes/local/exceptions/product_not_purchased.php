<?php

namespace local_ultimate_market\local\exceptions;

use moodle_url;
use moodle_exception;

/**
 * Product out of stock exception class.
 *
 * @package     local_ultimate_market
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */
class product_not_purchased extends moodle_exception {
    public function __construct($errorcode) {
        $url = new moodle_url('/');

        parent::__construct($errorcode, 'local_ultimate_market', $url, null, null);
    }
}
