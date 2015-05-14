<?php

require_once('../../config.php');
require_once($CFG->libdir.'/coursecatlib.php');
require_once($CFG->dirroot.'/blocks/moodleblock.class.php');
require_once($CFG->dirroot.'/blocks/featuredcourses/block_featuredcourses.php');
require_once($CFG->dirroot.'/blocks/featuredcourses/featuredcourses_form.php');

require_login();

$system_context = context_system::instance();

require_capability('block/featuredcourses:addinstance', $system_context);

$PAGE->set_pagelayout('admin');
$PAGE->set_url('/blocks/featuredcourses/featuredcourses.php');
$PAGE->set_context($system_context);

$args = array(
    'availablecourses' => coursecat::get(0)->get_courses(array('recursive' => true)),
    'featuredcourses' => block_featuredcourses::get_featured_courses()
);

$editform = new featuredcourses_form(null, $args);
if ($editform->is_cancelled()) {
    redirect($CFG->wwwroot.'/?redirect=0');
} else if ($data = $editform->get_data()) {

    if (isset($data->doadd) && $data->doadd == 1) {
        try {
            $DB->insert_record('block_featuredcourses', $data->newfeatured);
        } catch (Exception $e) {
            throw $e;
        }
    }

    if (isset($data->featured) && !empty($data->featured)) {
        try {
            foreach ($data->featured as $f) {
                $DB->update_record('block_featuredcourses', $f);
            }
        } catch (Exception $e) {
            throw new moodle_exception();
        }
    }
    redirect($CFG->wwwroot.'/blocks/featuredcourses/featuredcourses.php');
}

$site = get_site();

$PAGE->set_title(get_string('editpagetitle', 'block_featuredcourses'));
$PAGE->set_heading($site->fullname . ' - ' . 
                   get_string('pluginname', 'block_featuredcourses'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('editpagedesc', 'block_featuredcourses'));

$editform->display();

echo $OUTPUT->footer();
