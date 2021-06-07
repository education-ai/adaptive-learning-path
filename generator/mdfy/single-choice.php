<?php

function single_choice($correct, $wrong1, $wrong2, $head){
	$act_id = course_add_activity($head);
	course_log_add('single',array($correct[2]), array($wrong1[2], $wrong2[2]));

	$singlei = ' <json_content>{"media":{"type":{"params":{"contentName":"Bild"},"library":"H5P.Image 1.1","subContentId":"0feaf5b5-63f1-4afc-955a-f40e38ad7dad","metadata":{"contentType":"Image","license":"U","title":"Unbenannt: Image","authors":[],"changes":[]}},"disableImageZooming":false},"answers":[';

	$singlei .= '{"correct":true,"tipsAndFeedback":{"tip":"","chosenFeedback":"","notChosenFeedback":"&lt;div&gt;'.$correct[1].'&lt;\/div&gt;\n"},"text":"&lt;div&gt;'.$correct[0].'&lt;\/div&gt;\n"},';
	$singlei .= '{"correct":false,"tipsAndFeedback":{"tip":"","chosenFeedback":"'.$wrong1[1].'","notChosenFeedback":""},"text":"&lt;div&gt;'.$wrong1[0].'&lt;\/div&gt;\n"},
		{"correct":false,"tipsAndFeedback":{"tip":"","chosenFeedback":"'.$wrong2[1].'","notChosenFeedback":""},"text":"&lt;div&gt;'.$wrong2[0].'&lt;\/div&gt;\n"}';

	$singlei .= '],"overallFeedback":[{"from":0,"to":100}],"behaviour":{"enableRetry":false,"enableSolutionsButton":false,"enableCheckButton":true,"type":"single","singlePoint":true,"randomAnswers":true,"showSolutionsRequiresInput":true,"confirmCheckDialog":false,"confirmRetryDialog":false,"autoCheck":true,"passPercentage":100,"showScorePoints":false},"UI":{"checkAnswerButton":"\u00dcberpr\u00fcfen","showSolutionButton":"L\u00f6sung anzeigen","tryAgainButton":"Wiederholen","tipsLabel":"Hinweis anzeigen","scoreBarLabel":"Du hast :num von :total Punkten erreicht.","tipAvailable":"Hinweis verf\u00fcgbar","feedbackAvailable":"R\u00fcckmeldung verf\u00fcgbar","readFeedback":"R\u00fcckmeldung vorlesen","wrongAnswer":"Falsche Antwort","correctAnswer":"Richtige Antwort","shouldCheck":"H\u00e4tte gew\u00e4hlt werden m\u00fcssen","shouldNotCheck":"H\u00e4tte nicht gew\u00e4hlt werden sollen","noInput":"Bitte antworte, bevor du die L\u00f6sung ansiehst"},"confirmCheck":{"header":"Beenden?","body":"Ganz sicher beenden?","cancelLabel":"Abbrechen","confirmLabel":"Beenden"},"confirmRetry":{"header":"Wiederholen?","body":"Ganz sicher wiederholen?","cancelLabel":"Abbrechen","confirmLabel":"Best\u00e4tigen"},"question":"&lt;p&gt;';
	$singlei .= $head;
	$singlei .= '&lt;\/p&gt;\n"}</json_content>';

	$single = '<?xml version="1.0" encoding="UTF-8"?>
	<activity id="'.$act_id.'" moduleid="8" modulename="hvp" contextid="44">
	  <hvp id="'.$act_id.'">
		<name>'.$head.'</name>
		<machine_name>H5P.MultiChoice</machine_name>
		<major_version>1</major_version>
		<minor_version>14</minor_version>
		<intro></intro><introformat>1</introformat>'.$singlei.'<embed_type>div</embed_type>
		<disable>15</disable>
		<content_type>$@NULL@$</content_type>
		<source>$@NULL@$</source>
		<year_from>$@NULL@$</year_from>
		<year_to>$@NULL@$</year_to>
		<license_version>$@NULL@$</license_version>
		<changes>[]</changes>
		<license_extras>$@NULL@$</license_extras>
		<author_comments>$@NULL@$</author_comments>
		<slug>multi</slug>
		<timecreated>1595408343</timecreated>
		<timemodified>1595412160</timemodified>
		<authors>[]</authors>
		<license>U</license>
		<content_user_data>
		</content_user_data>
	  </hvp>
	</activity>';
	course_add_activity_content($single);
	course_add_activity_type('hvp');
	return $single;
}

?>
