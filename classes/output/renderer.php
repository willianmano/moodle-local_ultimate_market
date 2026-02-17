<?php

/**
 * ultimate_market main renderer
 *
 * @package     local_ultimate_market
 * @copyright   2021 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */

namespace local_ultimate_market\output;

defined('MOODLE_INTERNAL') || die;

use plugin_renderer_base;
use renderable;

/**
 * ultimate_market renderable class.
 *
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */
class renderer extends plugin_renderer_base {
    public function render_index(renderable $page) {
        $data = $page->export_for_template($this);

        return parent::render_from_template('local_ultimate_market/index', $data);
    }
}