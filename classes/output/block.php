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
class block implements renderable, templatable {
    protected $context;
    protected $course;

    public function __construct($course, $context) {
        $this->course = $course;
        $this->context = $context;
    }

    public function export_for_template(renderer_base $output) {
        $productentity = new product();
        $coinutil = new coin();

        return [
            'course' => $this->course->id,
            'coins' => $coinutil->get_user_coins(),
            'products' => $productentity->get_all_course_products($this->course->id, true, 5)
        ];
    }
}
