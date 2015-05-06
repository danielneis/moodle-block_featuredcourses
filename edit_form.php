<?php

class block_featuredcourses_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        global $CFG;

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        $mform->addElement('static', 'link', get_string('editlink', 'block_featuredcourses', $CFG->wwwroot.'/blocks/featuredcourses/featuredcourses.php'));
    }
}
