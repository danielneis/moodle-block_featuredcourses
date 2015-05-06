<?php

function featuredcourses_get_all() {
    global $DB;

    $sql = "SELECT c.id, c.shortname, c.fullname,
                   f.id, f.proximaturma, f.cargahoraria, f.valor,
                   f.linkprograma, f.linkinscrever, f.linkimagem
              FROM {course} c
              JOIN {block_featuredcourses} f
                ON (c.id = f.courseid)
             WHERE c.visible = 1";

    return $DB->get_records_sql($sql);
}
