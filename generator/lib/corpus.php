<?php


function course_add_activity($head){
	global $course_struct;
	array_push($course_struct,$head);
	return count($course_struct);
}
function course_add_activity_content($c){
	global $course_content;
	array_push($course_content,$c);
}
function course_add_activity_type($c){
	global $course_content_type;
	array_push($course_content_type,$c);
}

function course_log_add($c,$d,$f){
	global $course_log;
	array_push($course_log,array($c,$d,$f));
}

// remove directory
function rrmdir($src) {
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $src . '/' . $file;
            if ( is_dir($full) ) {
                rrmdir($full);
            }
            else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($src);
}

// Remove backup activites directory and create new one
function renewActivities(){
	global $CFG;
	global $backupdir;
	if (is_dir($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities'))
		rrmdir($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities');
	mkdir($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities');
}


// Put all activities into backup and generate moodle_backup.xml with all activities including necessary xml files
function createCourseCorpus(){
	global $CFG;
	global $course_struct;
	global $course_content;
	global $course_content_type;
	global $backupdir;
	global $sourcecourse;
	global $destcourse;
	global $GEN;
	
	$act = '';
	for ($i = 0; $i < count($course_struct); $i++){
		$act .= '<activity>
		  <moduleid>'.($i+1).'</moduleid>
		  <sectionid>1</sectionid>
		  <modulename>'.$course_content_type[$i].'</modulename>
		  <title>C</title>
		  <directory>activities/'.$course_content_type[$i].'_'.($i+1).'</directory>
		</activity>';
	}

	$ident = explode('.',$CFG->siteidentifier);
	$course_xml = '<?xml version="1.0" encoding="UTF-8"?>
<moodle_backup>
  <information>
	<name>backup.mbz</name>
	<moodle_version>2021051700</moodle_version>
	<moodle_release>3.11 (Build: 20210517)</moodle_release>
	<backup_version>2021051700</backup_version>
	<backup_release>3.11</backup_release>
	<backup_date>1621592160</backup_date>
	<mnet_remoteusers>0</mnet_remoteusers>
	<include_files>0</include_files>
	<include_file_references_to_external_content>0</include_file_references_to_external_content>
	<original_wwwroot>'.$CFG->wwwroot.'</original_wwwroot>
	<original_site_identifier_hash>'.$ident[0].'</original_site_identifier_hash>
	<original_course_id>'.$sourcecourse.'</original_course_id>
	<original_course_format>topics</original_course_format>
	<original_course_fullname>Course</original_course_fullname>
	<original_course_shortname>Course</original_course_shortname>
	<original_course_startdate>1595372400</original_course_startdate>
	<original_course_enddate>0</original_course_enddate>
	<original_course_contextid>25</original_course_contextid>
	<original_system_contextid>1</original_system_contextid>
	<details>
	  <detail backup_id="'.$backupdir.'">
		<type>course</type>
		<format>moodle2</format>
		<interactive>1</interactive>
		<mode>20</mode>
		<execution>1</execution>
		<executiontime>0</executiontime>
	  </detail>
	</details>
	<contents>
	  <activities>'.$act.'</activities>
	  <sections>
		<section>
		  <sectionid>0</sectionid>
		  <title>'.$GET->CourseTitle.'</title>
		  <directory>sections/section_0</directory>
		</section>
		<section>
		  <sectionid>1</sectionid>
		  <title>1</title>
		  <directory>sections/section_1</directory>
		</section>
	  </sections>
	  <course>
		<courseid>'.$destcourse.'</courseid>
		<title>'.$GET->CourseTitle.'</title>
		<directory>course</directory>
	  </course>
	</contents>
	<settings>
	  <setting>
		<level>root</level>
		<name>filename</name>
		<value>backup.mbz</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>imscc11</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>users</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>anonymize</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>role_assignments</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>activities</name>
		<value>1</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>blocks</name>
		<value>1</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>files</name>
		<value>1</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>filters</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>comments</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>badges</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>calendarevents</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>userscompletion</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>logs</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>grade_histories</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>questionbank</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>groups</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>competencies</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>root</level>
		<name>customfield</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>section</level>
		<section>section_0</section>
		<name>section_0_included</name>
		<value>1</value>
	  </setting>
	  <setting>
		<level>section</level>
		<section>section_0</section>
		<name>section_0_userinfo</name>
		<value>0</value>
	  </setting>
	  <setting>
		<level>section</level>
		<section>section_1</section>
		<name>section_1_included</name>
		<value>1</value>
	  </setting>
	  <setting>
		<level>section</level>
		<section>section_1</section>
		<name>section_1_userinfo</name>
		<value>0</value>
	  </setting>'; 
	$act = '';
	for ($i = 0; $i < count($course_struct); $i++){
		$act .= '<setting>
		<level>activity</level>
		<activity>'.$course_content_type[$i].'_'.($i+1).'</activity>
		<name>'.$course_content_type[$i].'_'.($i+1).'_included</name>
		<value>1</value>
	  </setting>
	  <setting>
		<level>activity</level>
		<activity>'.$course_content_type[$i].'_'.($i+1).'</activity>
		<name>'.$course_content_type[$i].'_'.($i+1).'_userinfo</name>
		<value>0</value>
	  </setting>';
	}

	$course_xml .= $act;
	$course_xml .= '
	</settings>
  </information>
</moodle_backup>';

	for ($i = 0; $i < count($course_struct); $i++){
		mkdir($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1));
		file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1).'/grade_history.xml','<?xml version="1.0" encoding="UTF-8"?><grade_history>  <grade_grades>  </grade_grades></grade_history>');
		file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1).'/filters.xml','<?xml version="1.0" encoding="UTF-8"?><filters><filter_actives></filter_actives><filter_configs></filter_configs></filters>');
		file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1).'/calendar.xml','<?xml version="1.0" encoding="UTF-8"?><events></events>');
		file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1).'/comments.xml','<?xml version="1.0" encoding="UTF-8"?><comments></comments>');
		file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1).'/completion.xml','<?xml version="1.0" encoding="UTF-8"?>
<completions>
  <completion id="1">
    <userid>2</userid>
    <completionstate>1</completionstate>
    <viewed>1</viewed>
    <timemodified>1622552512</timemodified>
  </completion>
</completions>');
file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1).'/competencies.xml','<?xml version="1.0" encoding="UTF-8"?>
<course_module_competencies>
  <competencies>
  </competencies>
</course_module_competencies>');
		file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1).'/grades.xml','<?xml version="1.0" encoding="UTF-8"?>
	<activity_gradebook>
	  <grade_items>
		<grade_item id="'.($i+1).'">
		  <categoryid>1</categoryid>
		  <itemname>'.$course_struct[$i].'</itemname>
		  <itemtype>mod</itemtype>
		  <itemmodule>hvp</itemmodule>
		  <iteminstance>1</iteminstance>
		  <itemnumber>0</itemnumber>
		  <iteminfo>$@NULL@$</iteminfo>
		  <idnumber></idnumber>
		  <calculation>$@NULL@$</calculation>
		  <gradetype>1</gradetype>
		  <grademax>10.00000</grademax>
		  <grademin>0.00000</grademin>
		  <scaleid>$@NULL@$</scaleid>
		  <outcomeid>$@NULL@$</outcomeid>
		  <gradepass>0.00000</gradepass>
		  <multfactor>1.00000</multfactor>
		  <plusfactor>0.00000</plusfactor>
		  <aggregationcoef>0.00000</aggregationcoef>
		  <aggregationcoef2>0.10000</aggregationcoef2>
		  <weightoverride>0</weightoverride>
		  <sortorder>2</sortorder>
		  <display>0</display>
		  <decimals>$@NULL@$</decimals>
		  <hidden>0</hidden>
		  <locked>0</locked>
		  <locktime>0</locktime>
		  <needsupdate>0</needsupdate>
		  <timecreated>1595364221</timecreated>
		  <timemodified>1595429049</timemodified>
		  <grade_grades>
		  </grade_grades>
		</grade_item>
	  </grade_items>
	  <grade_letters>
	  </grade_letters>
	</activity_gradebook>');
		file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1).'/inforef.xml','<?xml version="1.0" encoding="UTF-8"?>
	<inforef>
	  <grade_itemref>
		<grade_item>
		  <id>'.($i+1).'</id>
		</grade_item>
	  </grade_itemref>
	</inforef>');
		file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1).'/module.xml','<?xml version="1.0" encoding="UTF-8"?>
	<module id="'.($i+1).'" version="2020020500">
	  <modulename>hvp</modulename>
	  <sectionid>'.($i+1).'</sectionid>
	  <sectionnumber>1</sectionnumber>
	  <idnumber></idnumber>
	  <added>1595364220</added>
	  <score>0</score>
	  <indent>0</indent>
	  <visible>1</visible>
	  <visibleoncoursepage>1</visibleoncoursepage>
	  <visibleold>1</visibleold>
	  <groupmode>0</groupmode>
	  <groupingid>0</groupingid>
	  <completion>2</completion>
	  <completiongradeitemnumber>$@NULL@$</completiongradeitemnumber>
	  <completionview>1</completionview>
	  <completionexpected>0</completionexpected>
	  <availability>$@NULL@$</availability>
	  <showdescription>0</showdescription>
	  <tags>
	  </tags>
	</module>');
		file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1).'/roles.xml','<?xml version="1.0" encoding="UTF-8"?>
	<roles>
	  <role_overrides>
	  </role_overrides>
	  <role_assignments>
	  </role_assignments>
	</roles>');
		
		file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/activities/'.$course_content_type[$i].'_'.($i+1).'/'.$course_content_type[$i].'.xml',$course_content[$i]);

	}

	mkdir($CFG->dataroot.'/temp/backup/'.$backupdir.'/sections/section_0');
	file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/sections/section_0/section.xml','<?xml version="1.0" encoding="UTF-8"?>
	<section id="260">
	  <number>0</number>
	  <name>'.$GEN->CourseTitle.'</name>
	  <summary>'.$GEN->CourseDesc.'</summary>
	  <summaryformat>1</summaryformat>
	  <sequence></sequence>
	  <visible>1</visible>
	  <availabilityjson>{"op":"&amp;","c":[],"showc":[]}</availabilityjson>
	  <timemodified>1596040553</timemodified>
	</section>');
	mkdir($CFG->dataroot.'/temp/backup/'.$backupdir.'/sections/section_1');
	file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/sections/section_1/section.xml','<?xml version="1.0" encoding="UTF-8"?>
	<section id="260">
	  <number>0</number>
	  <name>'.$GEN->CourseTitle.'</name>
	  <summary>'.$GEN->CourseDesc.'</summary>
	  <summaryformat>1</summaryformat>
	  <sequence></sequence>
	  <visible>1</visible>
	  <availabilityjson>{"op":"&amp;","c":[],"showc":[]}</availabilityjson>
	  <timemodified>1596040553</timemodified>
	</section>');

	file_put_contents($CFG->dataroot.'/temp/backup/'.$backupdir.'/moodle_backup.xml',$course_xml);

}

?>