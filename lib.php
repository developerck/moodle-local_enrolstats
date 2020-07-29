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
 * This function extends the category navigation to add learning plan links.
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param context $coursecategorycontext The context of the course category
 */
function local_enrolstats_extend_navigation_category_settings(navigation_node $navigation, context_coursecat $coursecategorycontext) {
    global $USER;
   
    if (has_capability('local/enrolstats:access_enrolstats', $coursecategorycontext)) {
        $title = get_string('index_title', 'local_enrolstats');
        $path = new moodle_url("/local/enrolstats/index.php", array('categoryid' =>   $coursecategorycontext->instanceid));
        $settingsnode = navigation_node::create($title, $path,
                navigation_node::TYPE_SETTING, null, null,new pix_icon('i/report', ''));
        if (isset($settingsnode)) {
            $navigation->add_node($settingsnode);
        }
    }
}

