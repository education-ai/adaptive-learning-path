<?php
/**
 * Uses the Iframe Embedder of H5P to create a content-page (without iframe)
 */
function page_content($head,$content){
	$act_id = course_add_activity('iframe');
	$content .= '<style>.h5p-content-controls,.h5p-iframe-content{display:none !important}</style>';
	$content = str_replace('<','&lt;',$content);
	$content = str_replace('>','&gt;',$content);
	$content = str_replace('\\/','/',$content);
	
	// generate xml for iframe
	$redirect = '<?xml version="1.0" encoding="UTF-8"?>
<activity id="'.$act_id.'" moduleid="2150" modulename="hvp" contextid="'.$act_id.'">
  <hvp id="'.$act_id.'">
    <name>'.$head.'</name>
    <machine_name>H5P.IFrameEmbed</machine_name>
    <major_version>1</major_version>
    <minor_version>0</minor_version>
    <intro>'.$content.'</intro>
    <introformat>1</introformat>
    <json_content>{"resizeSupported":true"}</json_content>
    <embed_type>div</embed_type>
    <disable>15</disable>
    <content_type>$@NULL@$</content_type>
    <source>$@NULL@$</source>
    <year_from>$@NULL@$</year_from>
    <year_to>$@NULL@$</year_to>
    <license_version>$@NULL@$</license_version>
    <changes>[]</changes>
    <license_extras>$@NULL@$</license_extras>
    <author_comments>$@NULL@$</author_comments>
    <slug>titel</slug>
    <timecreated>1596045018</timecreated>
    <timemodified>1596045384</timemodified>
    <authors>[]</authors>
    <license>U</license>
    <content_user_data>
    </content_user_data>
  </hvp>
</activity>';
	
	course_add_activity_content($redirect);
	course_add_activity_type('hvp');
	return $redirect;
}

?>
