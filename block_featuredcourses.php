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
 * Newblock block caps.
 *
 * @package    block_featuredcourses
 * @copyright  Daniel Neis <danielneis@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_featuredcourses extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_featuredcourses');
    }

    function get_content() {
        global $CFG, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';
        $this->content->text = '';

        // user/index.php expect course context, so get one if page has module context.
        $currentcontext = $this->page->context->get_course_context(false);

        if (empty($currentcontext)) {
            return $this->content;
        }
        if ($this->page->course->id == SITEID) {
            $courses = $this->get_featured_courses();
            foreach ($courses as $c) {
                $this->content->text .= '<div class="container-fluid coursebox">';
                $this->content->text .= '<h2>'.$c->fullname. '</h2>';
                $this->content->text .= '<p>Próxima turma: '.$c->proximaturma. '</p>';
                $this->content->text .= '<p>Carga horária: '.$c->cargahoraria. 'h</p>';
                $this->content->text .= '<h2>R$ '.$c->valor. '</h2>';
                $this->content->text .= '<a href="'.$c->linkprograma. '" class="btn">PROGRAMA</a>';
                $this->content->text .= '<a href="'.$c->linkinscrever. '" class="btn">INSCREVER</a>';
                $this->content->text .= '<img src="'.$c->linkimagem. '" class="courseimage"/>';
                $this->content->text .= '</div>';
            }
        }

        return $this->content;
    }

    // my moodle can only have SITEID and it's redundant here, so take it away
    public function applicable_formats() {
        return array('all' => false,
                     'site' => true,
                     'site-index' => true);
    }

    public function instance_allow_multiple() {
          return false;
    }

    function has_config() {return true;}

    public function cron() {
        return true;
    }

    private function get_featured_courses() {
        global $DB;

        $sql = 'SELECT c.id, c.fullname,
                       fc.proximaturma, fc. cargahoraria, fc.valor,
                       fc.linkprograma, fc.linkinscrever, fc.linkimagem
                  FROM {block_featuredcourses} fc
                  JOIN {course} c
                    ON (c.id = fc.courseid)';
        return $DB->get_records_sql($sql);
    }
}
