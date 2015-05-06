<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');

/**
 * The form for handling featured courses.
 */
class featuredcourses_form extends moodleform {

    /**
     * Form definition.
     */
    function definition() {

        $mform = $this->_form;
        $availablecourses  = $this->_customdata['availablecourses']; // this contains the data of this form
        $featuredcourses  = $this->_customdata['featuredcourses']; // this contains the data of this form
        $availablecourseslist = array();
        foreach ($availablecourses as $c) {
            $availablecourseslist[$c->id] = $c->shortname . ' : ' . $c->fullname;
        }

        // Forms to edit existing featured courses 
        foreach ($featuredcourses as $c) {
            $mform->addElement('header','featured', get_string('featuredcourse', 'block_featuredcourses', $c->shortname . ' - '. $c->fullname));

            $mform->addElement('hidden', 'featured['.$c->id.'][id]', null);
            $mform->setType('featured['.$c->id.'][id]', PARAM_INT);
            $mform->setConstant('featured['.$c->id.'][id]', $c->id);

            $mform->addElement('text', 'featured['.$c->id.'][proximaturma]', get_string('proximaturma', 'block_featuredcourses'));
            //$mform->addRule('shortname', get_string('missingproximatuma'), 'required', null, 'client');
            $mform->setType('featured['.$c->id.'][proximaturma]', PARAM_TEXT);
            $mform->setDefault('featured['.$c->id.'][proximaturma]', $c->proximaturma);

            $mform->addElement('text', 'featured['.$c->id.'][cargahoraria]', get_string('cargahoraria', 'block_featuredcourses'));
            //$mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
            $mform->setType('featured['.$c->id.'][cargahoraria]', PARAM_INT);
            $mform->setDefault('featured['.$c->id.'][cargahoraria]', $c->cargahoraria);

            $mform->addElement('text', 'featured['.$c->id.'][valor]', get_string('price', 'block_featuredcourses'));
            //$mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
            $mform->setType('featured['.$c->id.'][valor]', PARAM_INT);
            $mform->setDefault('featured['.$c->id.'][valor]', $c->valor);

            $mform->addElement('text', 'featured['.$c->id.'][linkprograma]', get_string('linkprograma', 'block_featuredcourses'));
            //$mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
            $mform->setType('featured['.$c->id.'][linkprograma]', PARAM_URL);
            $mform->setDefault('featured['.$c->id.'][linkprograma]', $c->linkprograma);

            $mform->addElement('text', 'featured['.$c->id.'][linkinscrever]', get_string('linkinscrever', 'block_featuredcourses'));
            //$mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
            $mform->setType('featured['.$c->id.'][linkinscrever]', PARAM_URL);
            $mform->setDefault('featured['.$c->id.'][linkinscrever]', $c->linkinscrever);

            $mform->addElement('text', 'featured['.$c->id.'][linkimagem]', get_string('linkimagem', 'block_featuredcourses'));
            //$mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
            $mform->setType('featured['.$c->id.'][linkimagem]', PARAM_URL);
            $mform->setDefault('featured['.$c->id.'][linkimagem]', $c->linkimagem);
        }

        // Add a new featured course
        $mform->addElement('header','add', get_string('addfeaturedcourse', 'block_featuredcourses'));

        $mform->addElement('checkbox', 'doadd', get_string('doadd', 'block_featuredcourses'));

        $mform->addElement('select', 'newfeatured[courseid]', get_string('courseid', 'block_featuredcourses'), $availablecourseslist);
        $mform->disabledIf('newfeatured[courseid]', 'doadd', 'notchecked');

        $mform->addElement('text', 'newfeatured[proximaturma]', get_string('proximaturma', 'block_featuredcourses'));
        //$mform->addRule('shortname', get_string('missingproximatuma'), 'required', null, 'client');
        $mform->setType('newfeatured[proximaturma]', PARAM_TEXT);
        $mform->disabledIf('newfeatured[proximaturma]', 'doadd', 'notchecked');

        $mform->addElement('text', 'newfeatured[cargahoraria]', get_string('cargahoraria', 'block_featuredcourses'));
        //$mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
        $mform->setType('newfeatured[cargahoraria]', PARAM_INT);
        $mform->disabledIf('newfeatured[cargahoraria]', 'doadd', 'notchecked');

        $mform->addElement('text', 'newfeatured[valor]', get_string('price', 'block_featuredcourses'));
        //$mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
        $mform->setType('newfeatured[valor]', PARAM_INT);
        $mform->disabledIf('newfeatured[valor]', 'doadd', 'notchecked');

        $mform->addElement('text', 'newfeatured[linkprograma]', get_string('linkprograma', 'block_featuredcourses'));
        //$mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
        $mform->setType('newfeatured[linkprograma]', PARAM_URL);
        $mform->disabledIf('newfeatured[linkprograma]', 'doadd', 'notchecked');

        $mform->addElement('text', 'newfeatured[linkinscrever]', get_string('linkinscrever', 'block_featuredcourses'));
        //$mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
        $mform->setType('newfeatured[linkinscrever]', PARAM_URL);
        $mform->disabledIf('newfeatured[linkinscrever]', 'doadd', 'notchecked');

        $mform->addElement('text', 'newfeatured[linkimagem]', get_string('linkimagem', 'block_featuredcourses'));
        //$mform->addRule('shortname', get_string('missingshortname'), 'required', null, 'client');
        $mform->setType('newfeatured[linkimagem]', PARAM_URL);
        $mform->disabledIf('newfeatured[linkimagem]', 'doadd', 'notchecked');

        $mform->addElement('submit', 'save', get_string('savechanges'));

        $mform->closeHeaderBefore('save');
    }
}
