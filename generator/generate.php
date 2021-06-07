<?php
/**
 * This script generates a moodle online course with contents of 'mycourse.php' and enrols the current user to it.
 * Will be opened by next.php (no direct access should be possible)
 * Secured by sha256 Hash with $GEN->SecretHash and user ID 
 *
 * @copyright  2021 Sylvio Rüdian <ruediasy@informatik.hu-berlin.de>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../config.php');
require_once('config.php');
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
require_once($CFG->dirroot . '/backup/controller/backup_controller.class.php');
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->libdir .'/filelib.php');
$PAGE->set_cacheable(false);

// necessary get parameters
if (!isset($_GET['u'])) die(); if (!isset($_GET['h'])) die();
$USER->id = (int)$_GET['u']; $hash = $_GET['h'];

// security check
if ((hash('sha256',$GEN->SecretHash.($USER->id))) != $hash) die();

// course that is copied as base
$sourcecourse = $GEN->BaseCourse;

// administrator is used for backup functions
$admin = get_admin();

// libraries to generate H5P activities
include('mdfy/single-choice.php');
include('mdfy/redirect.php');
include('mdfy/page.php');

// libraries for backup and enrollments
include('lib/backup.php');
include('lib/corpus.php');
include('lib/str.php');
include('lib/user.php');

// course contents of the creator
include('mycourse.php');

// Temp vars
$course_struct = array();
$course_content = array();
$course_content_type = array();
$course_log = array();

// Get the course where the user is enrolled to
$destcourse = get_enrolled_course();

// Backup of base course to directory $backupdir
$backupdir = prepare_backup($sourcecourse,$admin);

// get Course contents
makeCourse();

// Add the last element of the course (redirect element to the generator)
redirect_course();

// Remove backup activities directory and create new one
renewActivities();

// Put all activities into backup and generate moodle_backup.xml with all activities 
createCourseCorpus();

// backup enrolment method of course
$enrolData = $DB->get_record('enrol', array('enrol'=>'manual', 'courseid'=>$destcourse));          

/// Restore from a directory
restore_backup($backupdir, $destcourse,$admin);

// restore enrolment method of course
$insertId = $DB->insert_record('enrol', $enrolData); 

// restore enrolment of user
enroll_user($USER->id, $destcourse, '');


?>
