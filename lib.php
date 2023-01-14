<?php
// This file is part of Moodle User Custom Report Plugin
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
 * @created    14/01/2023
 * @package    local_user_custom_report
 * @copyright  Miguel Magdalena}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function local_user_custom_report_extends_navigation(global_navigation $nav) {
    local_user_custom_report_extend_navigation($nav);
}

function local_user_custom_report_extend_navigation(global_navigation $nav) {
    
    //Nav menu in the page
    if (isloggedin()) {
        $context = context_system::instance();
        if (has_capability('local/user_custom_report:managereport', $context)) {

            $node = $nav->add(
                get_string('pluginname', 'local_user_custom_report'),
                new moodle_url('/local/user_custom_report/user_custom_report.php'),
                navigation_node::TYPE_CUSTOM,
                null,
                'local_user_custom_report',
                new pix_icon('i/settings', get_string('pluginname', 'local_user_custom_report'))
            );

            $node->showinflatnavigation = true;
        }
    }
}
