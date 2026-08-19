<?php

namespace local_ultimate_market\output;

defined('MOODLE_INTERNAL') || die();

use local_ultimate\util\coin;
use local_ultimate_market\local\entities\product;
use renderable;
use templatable;
use renderer_base;

/**
 * ultimate_market renderable class.
 *
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */
class index implements renderable, templatable {
    protected $courseid;
    protected $context;

    public function __construct($courseid, $context) {
        $this->courseid = $courseid;
        $this->context = $context;
    }

    public function export_for_template(renderer_base $output) {
        $productentity = new product();
        $coinutil = new coin();

        return [
            'courseid' => $this->courseid,
            'coins' => $coinutil->get_user_coins(),
            'products' => $productentity->get_site_and_course_products($this->courseid)
        ];
    }
}
