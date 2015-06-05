<?php
if (!isset($_SESSION['userinfo'][0]['samaccountname'][0])) {
	if ($_SESSION['localUID'] != $_GET['studentUID']) {
		$redir = "Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?n=logon.php";
		header($redir);
		
		exit;
	}
}

if (isset($_FILES['fileInput']['name'])) {
	$photoUser = Students::find_by_uid($_GET['studentUID']);
	
	$path_parts = pathinfo($_FILES['fileInput']['name']);
	//$fileDirname = $path_parts['dirname'];
	//$fileBasename = $path_parts['basename'];
	$fileExtension = $path_parts['extension'];
	//$fileName = $path_parts['filename'];
	
	$target_path = SITE_LOCATION . '/uploads/';
	$target_name = $photoUser->uid . "_" . date(U) . "." . $fileExtension;
	$target_path_name = $target_path . $target_name; 
	
	if(move_uploaded_file($_FILES['fileInput']['tmp_name'], $target_path_name)) {
		// file uploaded!
		$photoUser->photograph = $target_name;
		$photoUser->updatePhotograph();
		
		$messageOutput  = "<div class=\"alert alert-success\">";
		$messageOutput .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
		$messageOutput .= "<strong>Success!</strong> ";
		$messageOutput .= "The file '" . basename( $_FILES['fileInput']['name']) . "' has been uploaded and linked to UID: " . $photoUser->uid;
		$messageOutput .= "</div>";	
	} else{
		// error uploading file
		
		$messageOutput  = "<div class=\"alert alert-danger\">";
		$messageOutput .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
		$messageOutput .= "<strong>Error!</strong> ";
		$messageOutput .= "There was an error uploading the file '" . basename( $_FILES['fileInput']['name']) . "', please try again!";
		$messageOutput .= "</div>";	
	}
}

$user = Students::find_by_uid($_GET['studentUID']);
$logs = Logs::find_by_user_uid($_GET['studentUID']);
$courses = Courses::find_all();
$specificCourse = Courses::find_by_uid($user->course_code);
?>
<div class="row">
	<div class="page-header">
		<h1><?php echo $user->fullDisplayName(); ?> <small> UCAS: <?php echo $user->ucas; ?></small></h1>
	</div>
</div>
<div class="row">
	<div class="col-lg-3">
		<?php echo $user->imageURL(true); ?>
		<div class="clearfix"></div>
		<form id="addToRemoveForm" target="_self" method="post" enctype="multipart/form-data">
		<div class="control-group">
			<div class="controls">
				<input class="input-file" id="fileInput" name="fileInput" type="file">
			</div>
		</div>
		<div class="control-group">
			<br /><input type="submit" class="btn btn-small btn-primary btn-block" id="test" value="Upload Photograph" />
			<p class="help-block">Please upload a passport-style photo of yourself. Photos should be in colour and should show a close-up of your full head and shoulders. It must be only of you with no other objects or people, and should be unaltered by computer software.</p>
			<a href="#" id="example" class="btn btn-default btn-block btn-xs" rel="popover" data-placement="top" data-content="To facilitate the administration of the Admissions process it is useful for the college to hold a photo of each candidate. This is not mandatory and you are free to opt-out." data-original title="Why am I being asked for a photo?">Why am I being asked for a photo?</a>
		</div>
		</form>
	</div>
	<div class="col-lg-9">
		<ul class="nav nav-tabs" id="myTab">
			<li class="active"><a href="#details" data-toggle="tab">Student Details</a></li>
			<li><a href="#logs" data-toggle="tab">Logs</a></li>
			<?php if (isset($_SESSION['userinfo'][0]['samaccountname'][0])) {
						echo "<a href=\"pdfreport.php?n=student_summary.php&orientation=L&userUID=" . $user->uid . "\" class=\"btn btn-primary pull-right\" role=\"button\"><span class=\"glyphicon glyphicon-file\" aria-hidden=\"true\"></span> Export as PDF</a>";
					}
			?>
		</ul>
		
		<div class="tab-content">
			<div class="tab-pane fade in active" id="details">
				<form class="form-horizontal" role="form">
					<?php
					if (isset($_SESSION['userinfo'][0]['samaccountname'][0])) {
					?>
					<div class="form-group">
						<label for="inputUcas" class="col-lg-2 control-label">UCAS ID</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputUCAS" placeholder="UCAS ID" value="<?php echo $user->ucas; ?>">
						</div>
					</div>
					<?php
					}
					?>
					<div class="form-group">
						<label for="inputTitle" class="col-lg-2 control-label">Title</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputTitle" placeholder="Title" value="<?php echo $user->title; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputForenames" class="col-lg-2 control-label">Forename(s)</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputForenames" placeholder="Forename(s)" value="<?php echo $user->forenames; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputSurname" class="col-lg-2 control-label">Surname</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputSurname" placeholder="Surname" value="<?php echo $user->surname; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputCourseCode" class="col-lg-2 control-label">Course of Study</label>
						<div class="col-lg-10">
							<?php
							$output = "<select class=\"form-control\" id=\"inputCourseCode\" >";
							
							foreach ($courses AS $course) {
								if ($course->uid == $user->course_code) {
									$selected = "selected";
								} else {
									$selected = "";
								}
								$output .= "<option value=\"" . $course->uid . "\" " . $selected . ">" . $course->displayName() . "</option>";
							}
							
							$output .= "</select>";
							
							echo $output;
							?>
						</div>
					</div>
					<hr />
					<div class="form-group">
						<label for="inputStudentLocationType" class="col-lg-2 control-label">Student Location Type</label>
						<div class="col-lg-10">
							<select class="form-control" id="inputStudentLocationType" <?php if (!isset($_SESSION['userinfo'][0]['samaccountname'][0])) { echo " disabled"; }?>>
								<option value="Home" <?php if ($user->location_type == "Home") { echo " selected"; }?>>Home</option>
								<option value="EU" <?php if ($user->location_type == "EU") { echo " selected"; }?>>EU</option>
								<option value="Overseas" <?php if ($user->location_type == "Overseas") { echo " selected"; }?>>Overseas</option>
							</select>
						</div>
					</div>
					<hr />
					<div class="form-group">
						<label for="inputAdd1" class="col-lg-2 control-label">Address Line 1</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputAdd1" placeholder="Address Line 1" value="<?php echo $user->add1; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputAdd2" class="col-lg-2 control-label">Address Line 2</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputAdd2" placeholder="Address Line 2" value="<?php echo $user->add2; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputAdd3" class="col-lg-2 control-label">Address Line 3</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputAdd3" placeholder="Address Line 3" value="<?php echo $user->add3; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputAdd4" class="col-lg-2 control-label">Address Line 4</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputAdd4" placeholder="Address Line 4" value="<?php echo $user->add4; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputAdd5" class="col-lg-2 control-label">Address Line 5</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputAdd5" placeholder="Address Line 5" value="<?php echo $user->add5; ?>">
						</div>
					</div>
					<hr />
					<div class="form-group">
						<label for="inputEmail" class="col-lg-2 control-label">E-Mail Address</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputEmail" placeholder="Email Address" value="<?php echo $user->email; ?>">
							<span class="help-block">We will use this E-Mail address to confirm the receipt of these details.</span>
						</div>
					</div>
					
					<?php
					if ($user->location_type == "Overseas") {
					?>
					<div class="form-group">
						<label for="inputSkype" class="col-lg-2 control-label">Skype ID</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputSkype" placeholder="Skype ID (if available)" value="<?php echo $user->skype; ?>">
							<span class="help-block">Please note that Skype interviews can only be requested by overseas candidates.</span>
						</div>
					</div>
					<?php
					}
					?>
					
					<hr />
					
					<div class="form-group">
						<label for="inputPhone" class="col-lg-2 control-label">Contact Telephone Number</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputPhone" placeholder="Contact Telephone Number" value="<?php echo $user->phone; ?>">
							<span class="help-block">Please ensure that we will be able to contact you on this number during your stay in Oxford.</span>
						</div>
					</div>
					<hr />
					<div class="form-group">
						<label for="inputDate" class="col-lg-2 control-label">I'll arrive in Oxford on</label>
						<div class="col-lg-10">
							<input class="form-control" type="text" id="inputDate" value="<?php echo date('Y/m/d', strtotime($user->arrival_date)); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputTime" class="col-lg-2 control-label">Time</label>
						<div class="col-lg-10">
							<select id="inputTime" class="form-control" >
								<?php
								$times = array();
								$time = strtotime("00:00:00");
								$times["00:00:00"] = date("g:i a",$time);
								$output = "";
								
								for($i = 1;$i < 48;$i++) {
									$time = strtotime("+ 1 hour",$time);
									$key = date("H:i:s",$time);
									$times[$key] = date("g:i a",$time);
								}
								
								foreach($times AS $time => $timeFriendly) {
									if (date('H:i', strtotime($time)) == date('H:i', strtotime($user->arrival_time))) {
										$selected = "selected";
									} else {
										$selected = "";
									}
									$output .= "<option " . $selected . " value=\"" . $time . "\">" . $timeFriendly . "</option>";
								}
								echo $output;
								?>
							</select>
						</div>
					</div>
					<hr />
					<div class="form-group">
						<label for="inputDisability" class="col-lg-2 control-label">Disability</label>
						<div class="col-lg-10">
							<textarea class="form-control" rows="3" id="inputDisability"><?php echo $user->disability; ?></textarea>
							<span class="help-block">If you have any disability which may require special arrangements to be made, please enter details here.</span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputDiet" class="col-lg-2 control-label">Dietary Requirements</label>
						<div class="col-lg-10">
							<textarea class="form-control" rows="3" id="inputDiet"><?php echo $user->diet; ?></textarea>
							<span class="help-block">If you have any special dietary requirements, please enter details here.</span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputFeedback" class="col-lg-2 control-label">Opt-Out of Feedback to Referee</label>
						<div class="col-lg-10">
							<?php
							if ($user->optout == "1") {
								echo "<input type=\"checkbox\" class=\"form-control\" value=\"1\" id=\"inputOptOut\" checked>";
							} else {
								echo "<input type=\"checkbox\" class=\"form-control\" value=\"0\" id=\"inputOptOut\" >";
							}
							?>
							<p class="help-block">It is our policy to communicate decisions and/or feedback directly to your UCAS referee at the end of the admissions process. Some candidates prefer for this information to remain confidential. Please tick this box if you do not want St Edmund Hall to communicate decisions and/or feedback to your referee.</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<?php
							if (isset($_SESSION['userinfo'][0]['samaccountname'][0])) {
								echo "<button type=\"submit\" class=\"btn btn-primary btn-block\" id=\"updateUserButtonAdmin\">Admin Submit</button>";
							} else {
								if ($user->confirmed_attendance == 1) {
									echo "<button disabled type=\"submit\" class=\"btn btn-primary btn-block\" id=\"updateUserButtonUser\">You have already submitted your data</button>";
								} else {
									echo "<button type=\"submit\" class=\"btn btn-primary btn-block\" id=\"updateUserButtonUser\">Submit</button>";
								}
							}
							?>
							
							<input type="hidden" id="userUID" value="<?php echo $user->uid; ?>">
							<p class="lead">If you have any problems with this site please email <a href="mailto:admissions@seh.ox.ac.uk">admissions@seh.ox.ac.uk</a></p>
						</div>
					</div>
					<div id="response_added"></div>
				</form>
				
				

			<div class="clearfix"></div>
		<p><button class="btn btn-default btn-sm pull-right" disabled="disabled" type="button">Last Modified <?php echo convertToDateString($user->date_updated); ?></button></p>
			</div>
			<div class="tab-pane fade" id="logs">
				<table class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>Date/time</th>
						<th>Type</th>
						<th>Description</th>
						<th>IP</th>
					</tr>
					</thead>
					<tbody>
						<?php
						foreach($logs AS $log) {
							if ($log->type == "error") {
								$rowClass = "error";
							} elseif ($log->type == "warning") {
								$rowClass = "alert";
							} elseif ($log->type == "success") {
								$rowClass = "success";
							} else {
								$rowClass = "";
							}
							
							echo "<tr class=\"" . $rowClass . "\">";
							echo "<td>" . $log->date_created . "</td>";
							echo "<td>" . $log->title . "</td>";
							echo "<td>" . $log->description . "</td>";
							echo "<td>" . $log->ip . "</td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		
		
	</div>
</div>

<script>
$(function () {
	$('#example').popover();
});

$(function () {
	$('#myTab a:first').tab('show');
})

/*
$('#inputDate').datepicker({
	format: "yyyy/mm/dd",
	startDate: '<?php echo date('Y/m/d', strtotime($specificCourse->interview_startdate . "+5 days")); ?>',
    endDate: '<?php echo date('Y/m/d', strtotime($specificCourse->interview_startdate . "-5 days")); ?>'
});
*/

$('#inputDate').datepicker({
	format: "yyyy/mm/dd",
	todayBtn: true,
	startView: '<?php echo date('Y/m/d', strtotime($specificCourse->interview_startdate)); ?>',
	startDate: '<?php echo date('Y/m/d', strtotime($specificCourse->interview_startdate . "-5 days")); ?>',
    endDate: '<?php echo date('Y/m/d', strtotime($specificCourse->interview_startdate . "+5 days")); ?>'
});

$("#inputSkype").keyup(function() {
	$(function () {
		if($('#inputSkype').val()) {
			$("#inputDate").prop('disabled', true);
			$("#inputTime").prop('disabled', true);
			$("#inputDiet").prop('disabled', true);
		} else {
			$("#inputDate").prop('disabled', false);
			$("#inputTime").prop('disabled', false);
			$("#inputDiet").prop('disabled', false);
		}
	})
});

$(function () {
	if($('#inputSkype').val()) {
		$("#inputDate").prop('disabled', true);
		$("#inputTime").prop('disabled', true);
		$("#inputDiet").prop('disabled', true);
	}
})
</script>