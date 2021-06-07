# Generating adaptive Moodle Courses
This is the code used to generate adaptive online courses with Moodle. If you want to use it, please cite the paper where we published the idea of the generating engine:
<i>Sylvio Rüdian & Niels Pinkwart, Generating adaptive and personalized language learning online courses in Moodle with individual learning paths using templates, ICALT, 2021, IEEE</i>

Abstract: The adaption of online courses according to the user knowledge is not new, but its application is limited. The major problem is the lack of missing open-source technology to personalize online courses with individual learning paths on a large scale. In this paper, we introduce our open-source framework that allows us to generate adaptive online courses in Moodle. We focus on language learning as an example implementation. Courses are generated based on a knowledge base and several XML templates that allow the generation of interactive tasks using H5P. The novelty of our approach is the application and combination of existing Moodle libraries to generate individual online courses, although they were not designed for that purpose. It is the first working example that supports individual learning paths on a large scale in Moodle. 
<hr>
<h2>Steps to install the generating engine:</h2>

- Install Moodle
- Install H5P
- create folder "generate" in moodle directory
- Upload the experimental course generator files to new folder /generate

- Create an empty course in /course/edit.php?category=1 (with no end date)

- This first course has normally ID 2 /course/view.php?id=2

- Set this course ID in generator/config.php $GEN->BaseCourse (e.g. $GEN->BaseCourse = 2;)
(Hint: You can set more attributs there, e.g. a secret Code that should be changed manually in $GEN->SecretHash)

- Remove all contents in the moodle course, like Announcements and Topics. Thus you have an empty course.

- Install H5P activity "Single Choice" and "Iframe Embedder". You can find that when you want to create new interactive H5P content.

- Add an H5P activity (Iframe Embedder) and set Iframe Path to [path]/generator/next.php

- Logout from moodle
<hr>
<h2> Create your contents</h2>

Put your course contents into generator/mycourse.php. There you can also define your course logic, that can be different for every user. It contains a very simple sample course, that can be adjusted. In the current version, you can add information pages using HTML and single choice questions:

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
	page_content('Another Page','<h4>And now?</h4><p>This is just another example with <strong>html</strong></p>');

<h2>Important information</h2>

- Users should register at [path]/generator/register.php
- There, the account including an empty course is generated and the user is redirected to it.
- For login you can use the original moodle login

At the end of the course, users access /generator/next.php with the Iframe Embedder. This generates the new course contents and the user will be redirected to its beginning.

Have fun!
<hr>
<h2>NOTE</h2>
It is important to note that this is an experimental feature that should not be used in a productive environment.

<b>DO NOT INSTALL IT IN AN ALREADY PRODUCTIVELY USED INSTANCE OF MOODLE AS THIS COULD DAMAGE AND DELTE YOUR COURSES.</b>


Tested with MOODLE Version 3.11 (Build: 20210517). Be aware that the code may not meet the Moodle guidelines.

Drop me a line if you have questions or recommendations.
