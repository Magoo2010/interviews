<?php
if (!isset($_SESSION['userinfo'][0]['samaccountname'][0])) {
	$redir = "Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?n=logon.php";
	header($redir);
	
	exit;
}
?>
<?php
$settings = New Settings();
$emailConfirmation = $settings->find_by_setting_name("confirmation_email");
$emailWelcome = $settings->find_by_setting_name("welcome_email");

?>
<div class="page-header">
	<h1>Communication Preferences</h1>
</div>
<div class="row">
	<div class="col-lg-9">
		<h2><?php echo $emailConfirmation->setting_name; ?></h2>
		<p>This e-mail is sent to users as they update their details on this site</p>
		<p><a href="#" class="myeditable" data-pk="<?php echo $emailConfirmation->uid; ?>" id="<?php echo $emailConfirmation->setting_name ?>" data-type="textarea" data-name="<?php echo $emailConfirmation->setting_name ?>" data-url="modules/settings/actions/update.php"><?php echo $emailConfirmation->setting_value; ?></a></p>
		
		<h2><?php echo $emailWelcome->setting_name; ?></h2>
		<p>This e-mail is sent to new users as they are added to this site</p>
		<p><a href="#" class="myeditable" data-pk="<?php echo $emailWelcome->uid; ?>" id="<?php echo $emailWelcome->setting_name ?>" data-type="textarea" data-name="<?php echo $emailWelcome->setting_name ?>" data-url="modules/settings/actions/update.php"><?php echo $emailWelcome->setting_value; ?></a></p>
	</div>
	<div class="col-lg-3">
		<h3>Available variables</h3>
		<p><span class="btn btn-info btn-xs" id="email_insert_uid">uid</span> <span class="btn btn-info btn-xs" id="email_insert_ucas">ucas</span> <span class="btn btn-info btn-xs" id="email_insert_confirmed_attendance">confirmed_attendance</span></p>
		<p><span class="btn btn-info btn-xs" id="email_insert_title">title</span> <span class="btn btn-info btn-xs" id="email_insert_forenames">forenames</span> <span class="btn btn-info btn-xs" id="email_insert_surname">surname</span></p>
		<p><span class="btn btn-info btn-xs">course</span></p>
		<p><span class="btn btn-info btn-xs">add1</span> <span class="btn btn-info btn-xs">add2</span> <span class="btn btn-info btn-xs">add3</span> <span class="btn btn-info btn-xs">add4</span> <span class="btn btn-info btn-xs">add5</span></p>
		<p><span class="btn btn-info btn-xs">email</span> <span class="btn btn-info btn-xs">phone</span> <span class="btn btn-info btn-xs">skype</span></p>
		<p><span class="btn btn-default btn-xs">arrival_date</span> <span class="btn btn-default btn-xs">arrival_time</span></p>
		<p><span class="btn btn-info btn-xs">disability</span> <span class="btn btn-info btn-xs">diet</span> <span class="btn btn-info btn-xs">location_type</span></p>
		<p><span class="btn btn-info btn-xs">confirmed_attendance</span> <span class="btn btn-info btn-xs">optout</span></p>
		<p><span class="btn btn-default btn-xs">photograph</span></p>
		<p><span class="btn btn-default btn-xs">date_created</span> <span class="btn btn-default btn-xs">date_updated</span></p>
	</div>
</div>

<script>
$(document).ready(function() {
	$.fn.editable.defaults.mode = 'inline';     
	
	$('.myeditable').editable();
	/*
	$('.myeditable2').editable({
		escape: 'true',
		rows: 16
	});
	*/
});
</script>