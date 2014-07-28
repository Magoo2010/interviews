<?php
session_start();
require_once(dirname(__FILE__) . '/config.php');

require_once($_SERVER['DOCUMENT_ROOT'] . 'engine/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . 'engine/globalFunctions.php');

require_once($_SERVER['DOCUMENT_ROOT'] . 'modules/students/start.php');
require_once($_SERVER['DOCUMENT_ROOT'] . 'modules/logs/start.php');
require_once($_SERVER['DOCUMENT_ROOT'] . 'modules/settings/start.php');
require_once($_SERVER['DOCUMENT_ROOT'] . 'modules/courses/start.php');

require_once($_SERVER['DOCUMENT_ROOT'] . 'engine/adLDAP/adLDAP.php');
require_once($_SERVER['DOCUMENT_ROOT'] . 'engine/phpMailer/phpmailer.inc.php');

try {
    $adldap = new adLDAP();
}
catch (adLDAPException $e) {
    echo $e;
    exit();
}
?>