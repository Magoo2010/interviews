<?php
if (!isset($_SESSION['userinfo'][0]['samaccountname'][0])) {
	$redir = "Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?n=logon.php";
	header($redir);
	
	exit;
}
?>
<?php
$settings = New Settings();
$interviewArrivalStart = $settings->find_by_setting_name("interviews_arrival_start_date");
$interviewArrivalEnd = $settings->find_by_setting_name("interviews_arrival_end_date");
?>
<div class="row">
	<div class="span12">
		<div class="page-header">
			<h1>Settings</h1>
		</div>
	</div>
	<div class="span9">
		<form class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="inputArrivalStartDate">Interview Arrival Start Date</label>
			<div class="controls">
				<input type="text" id="inputArrivalStartDate" placeholder="YYYY-MM-DD" value="<?php echo $interviewArrivalStart->setting_value;?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputArrivalEndDate">Interview Arrival End Date</label>
			<div class="controls">
				<input type="text" id="inputArrivalEndDate" placeholder="YYYY-MM-DD" value="<?php echo $interviewArrivalEnd->setting_value;?>">
			</div>
		</div>
		</form>
	</div>
</div>