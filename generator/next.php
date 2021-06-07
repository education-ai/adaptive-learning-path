<?php
/* 
 * Start the generator with admin access
 * 
 * @copyright  2021 Sylvio Rüdian <ruediasy@informatik.hu-berlin.de>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../config.php');
require_once('config.php');
require_once($CFG->dirroot .'/course/lib.php');

// get current course + enrollment
$enrolData = $DB->get_record('user_enrolments', array('userid'=>$USER->id));  
$enrolid = $enrolData->enrolid;
$enrolData = $DB->get_record('enrol', array('id'=>$enrolid)); 
$course = $enrolData->courseid;

// generate new course, open generate with hash parameter (for security reason)
$make = file_get_contents($CFG->wwwroot.'/generator/generate.php?u='.$USER->id.'&h='.(hash('sha256',$GEN->SecretHash.($USER->id))));
$PAGE->set_cacheable(false);

// get first activity of user's course
$activities = get_array_of_activities($course);
$first_act = 0; $first = 0;
foreach($activities as $k => $v){
	if ($first_act == 0) $first_act = $v->cm;
	if ($first == 0) $first = $v->cm;
}
if ($first_act == 0) $first_act = $first;

// redirect user to first element of the course
?>You will be redirected...
<script>parent.document.location.href='<?php echo $CFG->wwwroot;?>/mod/hvp/view.php?id=<?php echo $first_act; ?>';</script>

