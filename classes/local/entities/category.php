<?php

namespace local_ultimate_market\local\entities;

/**
 * Category entity class.
 *
 * @package     local_ultimate_market
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */
class category extends base {
    protected $table = 'ultimate_market_categories';

    public function has_children($id) {
        global $DB;

        if ($DB->count_records('ultimate_market_products', ['categoryid' => $id])) {
            return true;
        }

        return false;
    }

    public function get_all_select() {
        $categories = $this->get_all();

        if (!$categories) {
            return [];
        }

        $records = [
            0 => get_string('selectanoption', 'local_ultimate_market')
        ];

        foreach ($categories as $category) {
            $records[$category->id] = $category->name;
        }

        return $records;
    }
}
