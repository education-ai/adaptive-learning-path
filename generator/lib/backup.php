<?php
/**
 * This script creates a backup of a moodle course or restores it manually 
 *
 * @copyright  2021 Sylvio Rüdian <ruediasy@informatik.hu-berlin.de>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
function prepare_backup($sourcecourse,$admin){
	$bc = new \backup_controller(\backup::TYPE_1COURSE, $sourcecourse,
		\backup::FORMAT_MOODLE, \backup::INTERACTIVE_NO, \backup::MODE_IMPORT, $admin->id);

	$bc->set_status(\backup::STATUS_AWAITING);

	$outcome = $bc->execute_plan();
	$results = $bc->get_results();

	$backupdir = basename($bc->get_plan()->get_basepath());
	$bc->destroy();
	unset($bc);
	return $backupdir;
}

function restore_backup($backupdir, $destcourse,$admin){
	global $CFG;
	if (file_exists($CFG->dataroot.'/temp/backup/'.$backupdir.'/course/course.xml')) {
		$controller = new \restore_controller($backupdir, $destcourse,
											\backup::INTERACTIVE_NO,
											\backup::MODE_IMPORT,
											$admin->id,
											 \backup::TARGET_CURRENT_DELETING);

		if (!$controller->execute_precheck()) {
			if ($controller->get_status() !== \backup::STATUS_AWAITING) {
				return false;
			}
		}

		$controller->execute_plan();
		rebuild_course_cache($destcourse);

	}
}

function restore_backup_add($backupdir, $destcourse,$admin){
	global $CFG;
	if (file_exists($CFG->dataroot.'/temp/backup/'.$backupdir.'/course/course.xml')) {
		$controller = new \restore_controller($backupdir, $destcourse,
											\backup::INTERACTIVE_NO,
											\backup::MODE_IMPORT,
											$admin->id,
											\backup::TARGET_CURRENT_ADDING);

		if (!$controller->execute_precheck()) {
			if ($controller->get_status() !== \backup::STATUS_AWAITING) {
				return false;
			}
		}

		$controller->execute_plan();
		rebuild_course_cache($destcourse);

	}
}


?>