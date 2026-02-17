<?php

/**
 * Index admin page.
 *
 * @package     local_ultimate_market
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */

require(__DIR__.'/../../config.php');

$id = required_param('id', PARAM_INT);
$course = $DB->get_record('course', ['id' => $id], '*', MUST_EXIST);

$context = context_course::instance($id);

require_course_login($id);

require_capability('moodle/course:update', $context);

$title = get_string('pluginname', 'local_ultimate_market') . ' : ' . $course->shortname;

$PAGE->set_url('/local/ultimate_market/courseproducts.php');
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_context($context);

echo $OUTPUT->header();

$renderer = $PAGE->get_renderer('local_ultimate_market', 'admin');

$contentrenderable = new \local_ultimate_market\output\courseproducts($context, $course);

echo $renderer->render($contentrenderable);

echo $OUTPUT->footer();
