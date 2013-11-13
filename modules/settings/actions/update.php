<?php
include_once("../../../engine/initialise.php");

if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value'])) {
	$post_key = $_POST['name'];
	$post_value = $_POST['value'];
	$post_uid = $_POST['pk'];
	
	$settings = New Settings();
	$emailConfirmation = $settings->find_by_setting_name($post_key);
		
	$emailConfirmation->inlineUpdate($post_key, $post_value);
}
?>