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

?><div class="row">
	<div class="span12">
		<div class="page-header">
			<h1>Communication Preferences</h1>
		</div>
	</div>
	<div class="span9">
		<div class="accordion" id="accordion2">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"><?php echo $emailConfirmation->setting_name; ?></a>
				</div>
				<div id="collapseOne" class="accordion-body collapse in">
					<div class="accordion-inner">
						<textarea rows="10" class="span8" id="<?php echo $emailConfirmation->setting_name ?>"><?php echo $emailConfirmation->setting_value; ?></textarea>
					</div>
				</div>
			</div>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">new user e-mail</a>
				</div>
				<div id="collapseTwo" class="accordion-body collapse">
					<div class="accordion-inner">
						<textarea rows="10" class="span8"></textarea>
					</div>
				</div>
			</div>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">Other</a>
				</div>
				<div id="collapseThree" class="accordion-body collapse">
					<div class="accordion-inner">
						<textarea rows="10" class="span8">other</textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="span3">
		<h3>Available variables</h3>
		<p><span class="btn btn-mini" id="email_insert_uid">uid</span> <span class="btn btn-mini" id="email_insert_ucas">ucas</span> <span class="btn btn-mini" id="email_insert_confirmed_attendance">confirmed_attendance</span></p>
		<p><span class="btn btn-mini" id="email_insert_title">title</span> <span class="btn btn-mini" id="email_insert_forenames">forenames</span> <span class="btn btn-mini" id="email_insert_surname">surname</span></p>
		<p><span class="btn btn-mini">course</span></p>
		<p><span class="btn btn-mini">add1</span> <span class="btn btn-mini">add2</span> <span class="btn btn-mini">add3</span> <span class="btn btn-mini">add4</span> <span class="btn btn-mini">add5</span></p>
		<p><span class="btn btn-mini">email</span> <span class="btn btn-mini">phone</span> <span class="btn btn-mini">skype</span></p>
		<p><span class="btn btn-mini">arrival_date</span> <span class="btn btn-mini">arrival_time</span></p>
		<p><span class="btn btn-mini">disability</span> <span class="btn btn-mini">diet</span></p>
		<p><span class="btn btn-mini">photograph</span></p>
		<p><span class="btn btn-mini">date_created</span> <span class="btn btn-mini">date_updated</span></p>
	</div>
</div>