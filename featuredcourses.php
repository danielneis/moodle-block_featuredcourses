<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version details
 *
 * @package    block_featuredcourses
 * @copyright  Daniel Neis <danielneis@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir.'/coursecatlib.php');
require_once($CFG->dirroot.'/blocks/moodleblock.class.php');
require_once($CFG->dirroot.'/blocks/featuredcourses/block_featuredcourses.php');
require_once($CFG->dirroot.'/blocks/featuredcourses/featuredcourses_form.php');

require_login();

$systemcontext = context_system::instance();

require_capability('block/featuredcourses:addinstance', $systemcontext);

$PAGE->set_pagelayout('admin');
$PAGE->set_url('/blocks/featuredcourses/featuredcourses.php');
$PAGE->set_context($systemcontext);

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
$PAGE->set_heading($site->fullname . ' - ' .  get_string('pluginname', 'block_featuredcourses'));

echo $OUTPUT->header(),

     $OUTPUT->heading(get_string('editpagedesc', 'block_featuredcourses')),

     $editform->render(),

     $OUTPUT->footer();
