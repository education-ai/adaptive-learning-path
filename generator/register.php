<?php 

/**
 * Simple registration out of Moodle Core that generates a new course, enrols the user and redirects him/her to it
 *
 * @copyright  2021 Sylvio Rüdian <ruediasy@informatik.hu-berlin.de>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
include('config.php');
include('lib/header.php');
include('lib/user.php');
include('lib/backup.php');

// active session?
if (isset($USER->id) && (int)$USER->id > 0)	{header('Location: course.php'); die;}
?>

<link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot;?>/theme/yui_combo.php?rollup/3.17.2/yui-moodlesimple.css" /><script id="firstthemesheet" type="text/css"></script><link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot;?>/theme/styles.php/boost/1621342570_1/all" />

<noscript>Please activate JavaScript.</noscript>

<div id="page" class="container-fluid mt-0">
<div id="page-content">
<div class="row justify-content-center mt-3">
<div class="col-xl-6 col-sm-8">
<div class="card">
    <div class="card-body">
       <h4>Register</h4><div></div>
	   <p>
<?php

if (isset($_POST['uname'])){
	// Post data
	$u_moodle = strip_tags($_POST['uname']);
	$user_password = strip_tags($_POST['password']);
	$email = strip_tags($_POST['email']);
	
	// check for missing data
	if (strlen($u_moodle) < 3){ echo '<br><strong>You forgot to enter a user name.</strong><br>';unset($_POST);}
	if (strlen($user_password) < 3){ echo '<br><strong>You forgot to enter a password.</strong><br>';unset($_POST);}
	if (strlen($email) < 3) {echo '<br><strong>You forgot to enter your email adress.</strong><br>';unset($_POST);}
	
}else {
	$u_moodle = '';	$user_password = ''; $email = '';
}

$form = '</p><form method="post" action="register.php">
<div class="form-group">
	<label for="uname" class="sr-only">Username</label>
	<input type="text" name="uname" value="'.$u_moodle.'" class="form-control" placeholder="Username*" autocomplete="username" maxlenght="30">
</div><div class="form-group">
	<label for="email" class="sr-only">Email</label>
	<input type="email" name="email" value="'.$email.'" class="form-control" placeholder="Email*" autocomplete="email" maxlenght="30">
</div>
<div class="form-group">
	<label for="password" class="sr-only">Password</label>
	<input type="password" name="password" id="password" value="'.$user_password.'" class="form-control" placeholder="Password" autocomplete="current-password" maxlenght="256">
</div>
<input type="submit" value="Create Account" class="btn btn-primary btn-block mt-3"><br>

</form></div></div></div></div></div></div></div>';

if (!isset($_POST['uname'])){
	echo $form;	exit();
}else{
	
	if ($DB->record_exists('user', array('email'=>$email))) {
		echo 'You already registered with that email';
		echo $form;	exit(); 
	}
	
	if ($DB->record_exists('user', array('username'=>$u_moodle))) {
		echo 'The username already exist. Please choose another one';
		echo $form;	exit(); 
	}
	
	if (strlen($u_moodle) < 3) {
		echo 'Your user name should consist of 3 chars at least.';
		echo $form;	exit(); 
	}
	
}
require_once('../config.php');
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
require_once($CFG->dirroot . '/backup/controller/backup_controller.class.php');
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->libdir .'/filelib.php');

$hp_moodle = password_hash($user_password, PASSWORD_DEFAULT); ///IMPORTANT!
$lname = '&nbsp;'; // change if you want to store the complete name

// add new user
$ins = new stdClass();
$ins->auth = 'manual';
$ins->confirmed = 1;
$ins->mnethostid = 1;
$ins->username = $u_moodle;
$ins->password = $hp_moodle;
$ins->firstname = $u_moodle;
$ins->lastname = $lname;
$ins->email = $email;
$ID_user = $DB->insert_record('user', $ins);
unset($ins);

// create new empty course
$data = new stdClass();
$data->category=1;
$data->fullname='Course of '.$u_moodle;
$data->shortname = 'Course '.$u_moodle;
$data->summary = ''; // create summary for the course
$data->summaryformat=0;
$data->format=1;
$data->showgrades=0;
$data->visible=1;
$course = create_course($data, null);

// enroll user to course
enroll_user($ID_user, $course->id, '');

$sourcecourse = $GEN->BaseCourse;
$destcourse = $course->id;

// Backup into a directory
$admin = get_admin();
$backupdir = prepare_backup($sourcecourse, $admin);

// Restore from a directory
restore_backup_add($backupdir, $destcourse, $admin);


// Auto Login und Redirect to course
user_login($u_moodle, $user_password, $CFG->wwwroot . '/course/view.php?id='.($course->id));

?>