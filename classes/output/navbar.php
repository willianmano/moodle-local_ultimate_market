<?php

namespace local_ultimate_market\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use templatable;
use renderer_base;

/**
 * ultimate_market renderable class.
 *
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */
class navbar implements renderable, templatable {
    public function export_for_template(renderer_base $output) {
        return [];
    }
}
