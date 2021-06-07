<?php

$GEN = new stdClass();   
$GEN->BaseCourse = 2;                                    
$GEN->CourseTitle = 'Title of my course';
$GEN->CourseDesc = 'Description of my course, can be modified in /generator/const.php';
$GEN->ButtonGenerateCourse = 'Generate new Course';
$GEN->MessageCourseGenerating = 'Great. Your new course will be generated...';
$GEN->SecretHash = '[replace-with-secret-random-set-of-chars]'; // should be a random String that is used to verify User IDs + Hash

?>