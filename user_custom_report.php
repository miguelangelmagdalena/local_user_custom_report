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
 * Version information
 *
 * @package    local_user_custom_report
 * @author     Miguel Magdalena
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require "$CFG->libdir/tablelib.php";

require_login();
$context = context_system::instance();
require_capability('local/user_custom_report:managereport', $context);

$plugin_url = new moodle_url('/local/user_custom_report/user_custom_report.php');
$PAGE->set_context($context);
$PAGE->set_url($plugin_url);
$PAGE->set_title(get_string('pluginname','local_user_custom_report'));
$PAGE->set_heading(get_string('tablename','local_user_custom_report'));

//Navbar
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('pluginname','local_user_custom_report'),$plugin_url);

//Download parameters for table
$download = optional_param('download', '', PARAM_ALPHA);
$table = new table_sql('uniqueid');
date_default_timezone_set('America/Argentina/Buenos_Aires');
$date = date('dmY-H-i-s', time());
$table->is_downloading($download, 
    get_string('pluginname','local_user_custom_report').'-'.$date,'report');

if (!$table->is_downloading()) {
    // Only print headers (footer) if not asked to download data
    // Print the page header
    echo $OUTPUT->header();
}

$table->define_columns(array('username', 'firstname', 'lastname','coursename'));
$table->define_headers(array(
    get_string('username','local_user_custom_report'),
    get_string('firstname','local_user_custom_report'),
    get_string('lastname','local_user_custom_report'),
    get_string('coursename','local_user_custom_report')));

//Sql query
$fields = 'DISTINCT ra.id AS id, u.username, u.firstname, u.lastname,
            c.fullname AS coursename';
$from = '{course} AS c
            JOIN {context} AS ctx ON c.id = ctx.instanceid
            JOIN {role_assignments} AS ra ON ra.contextid = ctx.id
            JOIN {user} AS u ON u.id = ra.userid';
$where = '1=1';
$table->set_sql($fields, $from, $where);
$table->define_baseurl($plugin_url);
$table->out(2, true);

if (!$table->is_downloading()) {
    echo $OUTPUT->footer();
}