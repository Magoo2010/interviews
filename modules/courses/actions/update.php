<?php
//require_once($_SERVER['DOCUMENT_ROOT'] . 'engine/initialise.php');
require_once('../../../engine/initialise.php');

if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value'])) {
	$post_key = $_POST['name'];
	$post_value = $_POST['value'];
	$post_uid = $_POST['pk'];
	
	$courseClass = new Courses();
	$courseClass->uid = $_POST['pk'];
	$course = $courseClass->find_by_uid($courseClass->uid);
	
	$course->inlineUpdate($post_uid, $post_key, $post_value);
}
?>