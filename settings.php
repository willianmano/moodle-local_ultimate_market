<?php

/**
 * This adds the custom fields management page.
 *
 * @package     local_ultimate_market
 * @copyright   2021 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */

defined('MOODLE_INTERNAL') || die;

if (!$ADMIN->locate('ultimate')) {
    $ADMIN->add('root', new admin_category('ultimate', 'Ultimate gamification'));
}

$ADMIN->add('ultimate', new admin_externalpage('pluginname', get_string('ultimate_market', 'local_ultimate_market'),
    new moodle_url('/local/ultimate_market/admin/index.php')));
