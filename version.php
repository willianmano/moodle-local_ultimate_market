<?php

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_ultimate_market
 * @copyright   2021 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'local_ultimate_market';
$plugin->release = '1.0.0';
$plugin->version = 20260802000;
$plugin->requires = 2022041200;
$plugin->maturity = MATURITY_STABLE;
$plugin->dependencies = [
    'local_ultimate' => 2022110500
];
