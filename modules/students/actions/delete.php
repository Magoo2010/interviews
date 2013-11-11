<?php
require_once($_SERVER['DOCUMENT_ROOT'] . 'engine/initialise.php');
$user = Students::find_by_uid($_POST['uid']);
$user->delete();

?>