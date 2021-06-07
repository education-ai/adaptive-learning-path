<?php

/* 
 * This is the course draft. Here you can add all your contents and questions of the course. 
 * The order that you use here will be used as the learning path in the online course.
 * If you want to use the database (e.g. to access the performance on tasks), use "global $DB;" in first line
 * 
 * @copyright  2021 Sylvio Rüdian <ruediasy@informatik.hu-berlin.de>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function makeCourse(){
	// use global vars if necessary
	// global $USER;
	// global $DB;
	
	/////////////// Description Page ///////////////
	page_content('Simple Page','<h4>Thats it</h4><p>It is all about content. This is just a sample page with <strong>html</strong></p><p>It is all about content. This is just a sample page with <strong>html</strong>. You can also use special chars like ÄÖÜß.</p>');
	
	/////////////// Single Choice  ///////////////
	$single_choice1 = single_choice(
		array('Correct','Feedback if not chosen',$id=1), 
		array('Wrong 1','Feedback Wrong 1',$id=2), 
		array('Wrong 2','Feedback Wrong 2',$id=3), 
		$question='What is A1?');
	
	/////////////// Single Choice  ///////////////
	$single_choice1 = single_choice(
		array('Correct','Feedback if not chosen',$id=4), 
		array('Wrong 1','Feedback Wrong 1',$id=5), 
		array('Wrong 2','Feedback Wrong 2',$id=6), 
		$question='What is B1?');
	
	/////////////// Description Page ///////////////
	page_content('Another Page','<h4>And now?</h4><p>It is all about content. This is just another example with <strong>html</strong></p>');
	
}

?>