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
 * Plugin administration pages are defined here.
 *
 * @package     local_enrolstats
 * @category    admin
 * @copyright   2020 Chandra Kishor <developerck@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * This function to prepare the data for download
 *
 * @param dataformat $dataformat csv|html|xlsx
 * @param categoryid $categoryid to fetch the data
 */
function local_enrolstats_download_stats($dataformat, $categoryid) {
    global $DB;
    if (ob_get_length()) {
        throw new coding_exception("Output can not be buffered before calling download_as_dataformat");
    }
    $classname = 'dataformat_' . $dataformat . '\writer';
    if (!class_exists($classname)) {
        throw new coding_exception("Unable to locate dataformat/$dataformat/classes/writer.php");
    }
    $format = new $classname;

    // The data format export could take a while to generate...
    set_time_limit(0);

    // Close the session so that the users other tabs in the same session are not blocked.
    \core\session\manager::write_close();

    // If this file was requested from a form, then mark download as complete (before sending headers).
    \core_form\util::form_download_complete();

    $columns = array(get_string('table_head_category', 'local_enrolstats'),
        get_string('table_head_course', 'local_enrolstats'),
        get_string('table_head_enrol_method', 'local_enrolstats'),
        get_string('table_head_enrol_instance', 'local_enrolstats'),
        get_string('index_active', 'local_enrolstats'),
        get_string('index_suspended', 'local_enrolstats'));
    $filename = date("dmY") . "_enrolstats";
    $format->set_filename($filename);
    $format->send_http_headers();
    // This exists to support all dataformats - see MDL-56046.
    if (method_exists($format, 'write_header')) {
        $format->write_header($columns);
    } else {
        $format->start_output();
        $format->start_sheet($columns);
    }

    $c = 0;
    $cats = array();
    $options = [];
    $options['recursive'] = true;
    $courses = core_course_category::get($categoryid)->get_courses($options);
    $cats = array();
    foreach ($courses as $c) {
        if (!array_key_exists($c->category, $cats)) {
            $cats[$c->category] = $DB->get_field("course_categories", "name", array("id" => $c->category));
        }
        $enrolinstances = enrol_get_instances($c->id, false);
        foreach ($enrolinstances as $enrolinstance) {
            if ($enrolplugin = enrol_get_plugin($enrolinstance->enrol)) {
                $name = $enrolplugin->get_instance_name($enrolinstance);
                $acount = $DB->count_records("user_enrolments", array("enrolid" => $enrolinstance->id, "status" => 0));
                $scount = $DB->count_records("user_enrolments", array("enrolid" => $enrolinstance->id, "status" => 1));
                $line = array();
                $line[] = $cats[$c->category];
                $line[] = $c->fullname;
                $line[] = $enrolinstance->enrol;
                $line[] = $name;
                $line[] = $acount;
                $line[] = $scount;
                $format->write_record($line, $c++);
            }
        }
    }

    if (method_exists($format, 'write_footer')) {
        $format->write_footer($columns);
    } else {
        $format->close_sheet($columns);
        $format->close_output();
    }
}

