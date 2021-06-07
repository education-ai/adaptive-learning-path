<?php

/* 
 * Libraries for user login and user enrolment
 * 
 * @copyright  2021 Sylvio Rüdian <ruediasy@informatik.hu-berlin.de>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// authenticate the user login and redirect to page $redirect
function user_login($u_moodle, $user_password, $redirect){
	$user = authenticate_user_login($u_moodle, $user_password);
	if ($user != false){
		if(complete_user_login($user)){   
			echo '<script type="text/javascript">window.location.href = "'.$redirect.'";</script><p>Falls du nicht automatisch weitergeleitet wird, klicke <a href="'.$red.'">[hier]</a></p>';
			return true;
		}
	}return false;
}

// get the course ID where the user is enrolled to (should be only one!)
function get_enrolled_course(){
	global $DB;
	global $USER;
	global $GEN;
	$enrolData = $DB->get_record('user_enrolments', array('userid'=>$USER->id));  
	$enrolid = $enrolData->enrolid;
	$enrolData = $DB->get_record('enrol', array('id'=>$enrolid)); 
	$course = $enrolData->courseid;
	
	if ((int)$course == 0 || $course == $GEN->BaseCourse) $destcourse = 3;
	else $destcourse = $course;
	return $destcourse;
}

// enrol user to course
// based on https://stackoverflow.com/questions/16012157/how-to-enroll-a-user-in-all-courses-on-moodle
function enroll_user($userid, $course, $modifier) {                                                
    global $DB;                                                                                    
    $enrolData = $DB->get_record('enrol', array('enrol'=>'manual', 'courseid'=>$course));          
    $user_enrolment = new stdClass();                                                              
        $user_enrolment->enrolid = $enrolData->id;                                                 
        $user_enrolment->status = '0';                                                             
        $user_enrolment->userid = $userid;                                                         
        $user_enrolment->timestart = time();                                                       
        $user_enrolment->timeend =  '0';                                                           
        $user_enrolment->modifierid = $modifier;                                                   
        $user_enrolment->timecreated = time();                                                     
        $user_enrolment->timemodified = time();                                                    
    $insertId = $DB->insert_record('user_enrolments', $user_enrolment);                            

    $context = $DB->get_record('context', array('contextlevel'=>50, 'instanceid'=>$course));          
    $role = new stdClass();                                                                        
        $role->roleid = 5;    // Teilnehmer                                                                     
        $role->contextid = $context->id;                                                           
        $role->userid = $userid;                                                                   
        $role->component = '';                                                                     
        $role->itemid = 0;                                                                         
        $role->timemodified = time();                                                              
        $role->modifierid = $modifier;                                                             
    $insertId2 = $DB->insert_record('role_assignments', $role);                                    
    return array('user_enrolment'=>$insertId, 'role_assignment'=>$insertId2);                      
}
