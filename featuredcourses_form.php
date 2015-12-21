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
 * The list of featured courses form.
 *
 * @package    block_featuredcourses
 * @copyright  Daniel Neis <danielneis@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');

/**
 * The form for handling featured courses.
 */
class featuredcourses_form extends moodleform {

    /**
     * Form definition.
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;
        $availablecourses  = $this->_customdata['availablecourses'];
        $featuredcourses  = $this->_customdata['featuredcourses'];
        $availablecourseslist = array();
        foreach ($availablecourses as $c) {
            $availablecourseslist[$c->id] = $c->shortname . ' : ' . $c->fullname;
        }

        // Forms to edit existing featured courses.
        foreach ($featuredcourses as $c) {
            $mform->addElement('header', 'featured',
                               get_string('featuredcourse', 'block_featuredcourses', $c->shortname . ' - '. $c->fullname));

            $mform->addElement('hidden', 'featured['.$c->id.'][id]', null);
            $mform->setType('featured['.$c->id.'][id]', PARAM_INT);
            $mform->setConstant('featured['.$c->id.'][id]', $c->id);

            $mform->addElement('text', 'featured['.$c->id.'][sortorder]', get_string('sortorder', 'block_featuredcourses'));
            $mform->addRule('featured['.$c->id.'][sortorder]',
                            get_string('missingsortorder', 'block_featuredcourses'), 'required', null, 'client');
            $mform->setType('featured['.$c->id.'][sortorder]', PARAM_INT);
            $mform->setDefault('featured['.$c->id.'][sortorder]', $c->sortorder);

            $mform->addElement('static', 'link',
                               get_string('deletelink', 'block_featuredcourses',
                                          $CFG->wwwroot.'/blocks/featuredcourses/delete_featuredcourse.php?courseid='.$c->id));

        }

        // Add a new featured course.
        $mform->addElement('header', 'add', get_string('addfeaturedcourse', 'block_featuredcourses'));

        $mform->addElement('checkbox', 'doadd', get_string('doadd', 'block_featuredcourses'));

        $mform->addElement('select', 'newfeatured[courseid]',
                           get_string('courseid', 'block_featuredcourses'), $availablecourseslist);
        $mform->addRule('newfeatured[courseid]', get_string('missingcourseid', 'block_featuredcourses'),
                        'required', null, 'client');
        $mform->disabledIf('newfeatured[courseid]', 'doadd', 'notchecked');

        $mform->addElement('text', 'newfeatured[sortorder]', get_string('sortorder', 'block_featuredcourses'));
        $mform->addRule('newfeatured[sortorder]', get_string('missingsortorder', 'block_featuredcourses'),
                        'required', null, 'client');
        $mform->setType('newfeatured[sortorder]', PARAM_INT);
        $mform->disabledIf('newfeatured[sortorder]', 'doadd', 'notchecked');

        $mform->addElement('submit', 'save', get_string('savechanges'));

        $mform->closeHeaderBefore('save');
    }
}
