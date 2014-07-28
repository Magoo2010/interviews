<?php
if (!isset($_SESSION['userinfo'][0]['samaccountname'][0])) {
	$redir = "Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?n=logon.php";
	header($redir);
	
	exit;
}
$invitees = Students::find_all_invitees();
$confirmed = Students::find_all_confirmed();
$unconfirmed = Students::find_all_unconfirmed();

$arrivalDates = interviewArrivalDates();
$courses = Courses::find_all();
?>
<div class="row">
	<div class="span12">
		<div class="page-header">
			<h1>Users <small>sub-header</small></h1>
		</div>
		<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		
		<div class="tabbable"> <!-- Only required for left/right tabs -->
			<ul class="nav nav-tabs" id="myTab">
				<li class="active"><a href="#students" data-toggle="tab"><span class="badge"><?php echo count($invitees); ?></span> Invited</a></li>
				<li><a href="#confirmed" data-toggle="tab"><span class="badge"><?php echo count($confirmed); ?></span> Confirmed</a></li>
				<li><a href="#unconfirmed" data-toggle="tab"><span class="badge"><?php echo count($unconfirmed); ?></span> Unconfirmed</a></li>
				<li><a href="#addnew" data-toggle="tab">Add New</a></li>
			</ul>
			
			

			
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade in active" id="students">
					<p><a class="btn btn-info btn-small pull-right" href="modules/students/nodes/csv_allusers.php"><i class="icon-file"></i> Export As CSV</a></p>
					<p>I'm in Section 1.</p>
					<div class="clearfix"></div>
					<table class="table table-bordered table-striped">
						<thead>
						<tr>
							<th width="10%">UCAS ID Number</th>
							<th width="22%">Full Name</th>
							<th width="20%">Subject</th>
							<th width="25%" class="visible-lg visible-md">Data Checks</th>
							<th width="8%">Options</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach($invitees AS $user) {
							$course = Courses::find_by_uid($user->course_code);
							
							echo "<tr>";
							echo "<td>" . $user->ucas . "</td>";
							echo "<td><a href=\"index.php?m=students&n=user.php&studentUID=" . $user->uid . "\">" . $user->fullDisplayName() . "</a></td>";
							echo "<td>" . $course->displayName() . "</td>";
							echo "<td class=\"visible-lg visible-md\">";
							echo $user->datachecks();
							echo "</td>";
							echo "<td>";
							echo "<div class=\"btn-group\">";
							echo "<button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\">Action <span class=\"caret\"></span></button>";
							echo "<ul class=\"dropdown-menu\" role=\"menu\">";
							echo "<li><a href=\"#\" id=\"" . $user->uid . "\" class=\"deleteUserButton\">Delete User</a></li>";
							echo "</ul>";
							echo "</div>";
							echo "</td>";
							echo "</tr>";
						}
						?>
						</tbody>
					</table>
				</div>
				
				<div class="tab-pane fade" id="confirmed">
					<p><a class="btn btn-info btn-small pull-right" href="modules/students/nodes/csv_confirmedusers.php"><i class="icon-file"></i> Export As CSV</a></p>
					<table class="table table-bordered table-striped">
						<thead>
						<tr>
							<th width="10%">UCAS ID Number</th>
							<th width="22%">Full Name</th>
							<th width="20%">Subject</th>
							<th width="25%" class="visible-lg visible-md">Data Checks</th>
							<th width="8%">Options</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach($confirmed AS $user) {
							$course = Courses::find_by_uid($user->course_code);
							
							echo "<tr>";
							echo "<td>" . $user->ucas . "</td>";
							echo "<td><a href=\"index.php?m=students&n=user.php&studentUID=" . $user->uid . "\">" . $user->fullDisplayName() . "</a></td>";
							echo "<td>" . $course->displayName() . "</a></td>";
							echo "<td>" . $user->datachecks() . "</td>";
							echo "<td>options</td>";
							echo "</tr>";
						}
						?>
						</tbody>
					</table>
				</div>
				
				<div class="tab-pane fade" id="unconfirmed">
					<p><a class="btn btn-info btn-small pull-right" href="modules/students/nodes/csv_unconfirmedusers.php"><i class="icon-file"></i> Export As CSV</a></p>
					<table class="table table-bordered table-striped">
						<thead>
						<tr>
							<th width="10%">UCAS ID Number</th>
							<th width="22%">Full Name</th>
							<th width="20%">Subject</th>
							<th width="25%" class="visible-lg visible-md">Data Checks</th>
							<th width="8%">Options</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach($unconfirmed AS $user) {
							$course = Courses::find_by_uid($user->course_code);
							
							echo "<tr>";
							echo "<td>" . $user->ucas . "</td>";
							echo "<td><a href=\"index.php?m=students&n=user.php&studentUID=" . $user->uid . "\">" . $user->fullDisplayName() . "</a></td>";
							echo "<td>" . $course->displayName() . "</a></td>";
							echo "<td>" . $user->datachecks() . "</td>";
							echo "<td>options</td>";
							echo "</tr>";
						}
						?>
						</tbody>
					</table>
				</div>
				
				<div class="tab-pane fade" id="addnew">
					<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputUCAS">UCAS ID</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputUCAS" placeholder="UCAS ID">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputTitle">Title</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputTitle" placeholder="Title">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputForenames">Forename(s)</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputForenames" placeholder="Forename(s)">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputSurname">Surname</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputSurname" placeholder="Surname">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputCourse">Course of Study</label>
						<div class="col-lg-10">
							<?php
							$output = "<select class=\"form-control\" id=\"inputCourseCode\" >";
							
							foreach ($courses AS $course) {
								$output .= "<option value=\"" . $course->uid . "\">" . $course->displayName() . "</option>";
							}
							
							$output .= "</select>";
							
							echo $output;
							?>
						</div>
					</div>
					
					<hr />
					
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputStudentLocationType">Student Location Type</label>
						<div class="col-lg-10">
							<select class="form-control" id="inputStudentLocationType">
								<option value="Home">Home</option>
								<option value="EU">EU</option>
								<option value="Overseas">Overseas</option>
							</select>
						</div>
					</div>
					
					<hr />
					
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputAdd1">Address Line 1</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputAdd1" placeholder="Address Line 1">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputAdd2">Address Line 2</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputAdd2" placeholder="Address Line 2">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputAdd1">Address Line 3</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputAdd3" placeholder="Address Line 3">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputAdd4">Address Line 4</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputAdd4" placeholder="Address Line 4">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputAdd5">Address Line 5</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputAdd5" placeholder="Address Line 5">
						</div>
					</div>
					
					<br />
					
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputEmail">E-Mail Address</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputEmail" placeholder="Email Address">
							<span class="help-block">This E-Mail address will be used to send the confirmation E-Mail.</span>
						</div>
					</div>
					
					<hr />
					
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputPhone">Contact Telephone Number</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputPhone" placeholder="Contact Telephone Number">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputSkype">Skype ID</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputSkype" placeholder="Skype ID (if available)">
						</div>
					</div>
					
					<hr />
					
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputDate">I shall arrive in Oxford on</label>
						<div class="col-lg-10">
							<input class="form-control" type="text" id="inputDate" value="<?php echo date('Y/m/d');?>">
							<span class="help-block">This date will limit date selections to +/- 5 days for the students.</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputTime">Time</label>
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
									$output .= "<option value=\"" . $time . "\">" . $timeFriendly . "</option>";
								}
								echo $output;
								?>
							</select>
						</div>
					</div>
					
					<hr />
					
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputDisability">Disability</label>
						<div class="col-lg-10">
							<textarea class="form-control" rows="3" id="inputDisability"></textarea>
							<span class="help-block">Please list any disability which may require special arrangements to be made.</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputDiet">Dietary Requirements</label>
						<div class="col-lg-10">
							<textarea class="form-control" rows="3" id="inputDiet"></textarea>
							<span class="help-block">Please list any special dietary requirements.</span>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<div class="checkbox">
								<label><input type="checkbox" id="sendEmail" checked value="true">E-Mail candidate confirmation letter</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<button type="submit" id="createNewUserButton" class="btn btn-primary">Submit</button>
						</div>
					</div>

					</form>
				</div>
<div id="responseAdded"></div>
			</div>
		</div>
	</div>
</div>

<script>
$('#inputDate').datepicker({
	format: "yyyy/mm/dd",
	todayBtn: true,
	startView: '<?php echo date('Y/m/d', strtotime($specificCourse->interview_startdate)); ?>'
});
</script>