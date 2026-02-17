<?php

namespace local_ultimate_market\output\admin;

defined('MOODLE_INTERNAL') || die();

use renderable;
use templatable;
use renderer_base;
use local_ultimate_market\local\entities\product;

/**
 * ultimate_market renderable class.
 *
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */
class products implements renderable, templatable {
    protected $context;

    public function __construct($context) {
        $this->context = $context;
    }

    public function export_for_template(renderer_base $output) {
        $productentity = new product();

        return [
            'products' => $productentity->get_all()
        ];
    }
}
