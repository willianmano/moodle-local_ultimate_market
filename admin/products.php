<?php

/**
 * Products admin page.
 *
 * @package     local_ultimate_market
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */

require(__DIR__.'/../../../config.php');

$action = optional_param('action', null, PARAM_ALPHANUMEXT);
$id = optional_param('id', null, PARAM_INT);

require_login();
$context = context_system::instance();
require_capability('moodle/site:config', $context);

$params = [];
if ($action) {
    $params['action'] = $action;
}

if ($id) {
    $params['id'] = $id;
}

$url = new moodle_url('/local/ultimate_market/admin/products.php', $params);

$PAGE->set_context($context);

$PAGE->set_url($url);
$PAGE->set_title(get_string('products', 'local_ultimate_market'));
$PAGE->set_heading(get_string('products', 'local_ultimate_market'));

\local_ultimate_market\util\menu::fill_secondary_menu_with_admin_items();

$renderer = $PAGE->get_renderer('local_ultimate_market', 'admin');

if (!$action) {
    $contentrenderable = new \local_ultimate_market\output\admin\products($context);

    echo $OUTPUT->header();

    echo $renderer->render($contentrenderable);

    echo $OUTPUT->footer();

    exit;
}

$redirecturl = new moodle_url('/local/ultimate_market/admin/products.php');

$productentity = new \local_ultimate_market\local\entities\product();

$dbproduct = null;
if ($action == 'update' || $action == 'delete') {
    $dbproduct = $DB->get_record('ultimate_market_products', ['id' => $id], '*', MUST_EXIST);
}

if ($action == 'delete') {
    try {
        if (!confirm_sesskey()) {
            redirect($redirecturl, get_string('invaliddata', 'error'), null, \core\output\notification::NOTIFY_ERROR);
        }

        $id = required_param('id', PARAM_INT);

        if ($productentity->has_children($id)) {
            redirect($redirecturl, get_string('deleteitem_itemwithchildren', 'error'), null, \core\output\notification::NOTIFY_WARNING);
        }

        list($success, $message) = $productentity->delete($id);

        if ($success) {
            redirect($redirecturl, $message, null, \core\output\notification::NOTIFY_SUCCESS);
        }

        redirect($redirecturl, $message, null, \core\output\notification::NOTIFY_ERROR);

    } catch (\Exception $e) {
        redirect($redirecturl, get_string('invaliddata', 'error'), null, \core\output\notification::NOTIFY_ERROR);
    }
}

if ($action == 'toggleenabled') {
    if (!confirm_sesskey()) {
        redirect($redirecturl, get_string('invaliddata', 'error'), null, \core\output\notification::NOTIFY_ERROR);
    }

    $id = required_param('id', PARAM_INT);

    list($success, $message) = $productentity->toggle_enabled($id);

    if ($success) {
        redirect($redirecturl, $message, null, \core\output\notification::NOTIFY_SUCCESS);
    }

    redirect($redirecturl, $message, null, \core\output\notification::NOTIFY_ERROR);
}

$form = new \local_ultimate_market\forms\admin\products($url, $dbproduct);

if ($form->is_cancelled()) {
    redirect($redirecturl);
}

if ($formdata = $form->get_data()) {
    $stock = null;
    if ($formdata->stock == 0 || $formdata->stock != '') {
        $stock = (int) $formdata->stock;
    }

    $limitperuser = null;
    if ($formdata->limitperuser == 0 || $formdata->limitperuser != '') {
        $limitperuser = (int) $formdata->limitperuser;
    }

    $product = new \stdClass();
    $product->categoryid = $formdata->categoryid;
    $product->courseid = $formdata->courseid ?? null;
    $product->name = $formdata->name;
    $product->description = $formdata->description;
    $product->price = $formdata->price;
    $product->type = $formdata->type;
    $product->stock = $stock;
    $product->limitperuser = $limitperuser;
    $product->timemodified = time();

    $redirecturl = new moodle_url('/local/ultimate_market/admin/products.php');

    $success = false;
    $message = '';
    if ($action == 'create') {
        $product->timecreated = time();

        list($success, $message) = $productentity->create($product);
    }

    if ($action == 'update') {
        $product->id = $id;

        list($success, $message) = $productentity->update($product);
    }

    if ($success) {
        redirect($redirecturl, $message, null, \core\output\notification::NOTIFY_SUCCESS);
    }

    redirect($redirecturl, $message, null, \core\output\notification::NOTIFY_ERROR);
}

echo $OUTPUT->header();

$form->display();

echo $OUTPUT->footer();
