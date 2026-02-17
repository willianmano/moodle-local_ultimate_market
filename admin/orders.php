<?php

/**
 * Index admin page.
 *
 * @package     local_ultimate_market
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */

require(__DIR__.'/../../../config.php');

require_login();

$context = context_system::instance();

require_capability('moodle/site:config', $context);

$PAGE->set_context($context);
$PAGE->set_url('/local/ultimate_market/admin/orders.php');
$PAGE->set_title(get_string('pluginname', 'local_ultimate_market'));
$PAGE->set_heading(get_string('pluginname', 'local_ultimate_market'));

\local_ultimate_market\util\menu::fill_secondary_menu_with_admin_items();

echo $OUTPUT->header();

$renderer = $PAGE->get_renderer('local_ultimate_market', 'admin');

$contentrenderable = new \local_ultimate_market\output\admin\orders($context);

echo $renderer->render($contentrenderable);

echo $OUTPUT->footer();
