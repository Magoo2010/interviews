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
							<th>UCAS Number</th>
							<th>Full Name</th>
							<th>E-Mail</th>
							<th>Data Checks</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach($invitees AS $user) {
							echo "<tr>";
							echo "<td>" . $user->ucas . "</td>";
							echo "<td><a href=\"index.php?m=students&n=user.php&studentUID=" . $user->uid . "\">" . $user->fullDisplayName() . "</a></td>";
							echo "<td>" . $user->email . "</a></td>";
							echo "<td>";
								echo "<div class=\"btn-group\">";
								// email check
								if ($user->email) {
									$altText = "User has provided an E-Mail address";
									$buttonImage = "<i class=\"icon-envelope\"></i>";
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-success\">" . $buttonImage . "</a>";
								} else {
									$altText = "User has not provided an E-Mail address";
									$buttonImage = "<i class=\"icon-envelope\"></i>";
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-default\">" . $buttonImage . "</a>";
								}
								// mobile check
								if ($user->phone) {
									$altText = "User has provided an telephone number";
									$buttonImage = "<i class=\"icon-phone\"></i>";
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-success\">" . $buttonImage . "</a>";
								} else {
									$altText = "User has not provided an telephone number";
									$buttonImage = "<i class=\"icon-phone\"></i>";
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-default\">" . $buttonImage . "</a>";
								}
								// skype check
								if ($user->skype) {
									$altText = "User has provided a Skype ID";
									$buttonImage = "<i class=\"icon-skype\"></i>";
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-success\">" . $buttonImage . "</a>";
								} else {
									$altText = "User has not provided a Skype ID";
									$buttonImage = "<i class=\"icon-skype\"></i>";
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-default\">" . $buttonImage . "</a>";
								}
								// address check
								if ($user->add5) {
									$altText = "User has provided an address";
									$buttonImage = "<i class=\"icon-home\"></i>";
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-success\">" . $buttonImage . "</a>";
								} else {
									$altText = "User has not provided an address";
									$buttonImage = "<i class=\"icon-home\"></i>";
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-default\">" . $buttonImage . "</a>";
								}
								// date/time check
								if ($user->arrival_date) {
									$altText = "User has provided an arrival date";
									$buttonImage = "<i class=\"icon-calendar\"></i>";
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-success\">" . $buttonImage . "</a>";
								} else {
									$altText = "User has not provided an arrival date";
									$buttonImage = "<i class=\"icon-calendar\"></i>";
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-default\">" . $buttonImage . "</a>";
								}
								// photo check
								if ($user->photograph) {
									$altText = "User has uploaded a photograph";
									$buttonImage = "<i class=\"icon-picture\"></i>";
									
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-success\">" . $buttonImage . "</a>";
								} else {
									$altText = "User has not uploaded a photograph";
									$buttonImage = "<i class=\"icon-picture\"></i>";
									echo "<a href=\"#\" title=\"" . $altText. "\" alt=\"" . $altText . "\" class=\"btn btn-small btn-default\">" . $buttonImage . "</a>";
								}
								
								echo "</div>";
							/*
								public $course;

	public $arrival_date;
	public $arrival_time;
	public $disability;
	public $diet;
	public $date_created;
	public $date_updated;
	*/
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
							<th>BodCard</th>
							<th>Full Name</th>
							<th>Full Name</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach($confirmed AS $user) {
							echo "<tr>";
							echo "<td>" . $user->uid . "</td>";
							echo "<td><a href=\"index.php?m=students&n=user.php&studentUID=" . $user->uid . "\">" . $user->fullDisplayName() . "</a></td>";
							echo "<td><a href=\"index.php?m=students&n=user.php&studentUID=" . $user->uid . "\">" . $user->fullDisplayName() . "</a></td>";
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
							<th>BodCard</th>
							<th>Full Name</th>
							<th>Full Name</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach($unconfirmed AS $user) {
							echo "<tr>";
							echo "<td>" . $user->uid . "</td>";
							echo "<td><a href=\"index.php?m=students&n=user.php&studentUID=" . $user->uid . "\">" . $user->fullDisplayName() . "</a></td>";
							echo "<td><a href=\"index.php?m=students&n=user.php&studentUID=" . $user->uid . "\">" . $user->fullDisplayName() . "</a></td>";
							echo "</tr>";
						}
						?>
						</tbody>
					</table>
				</div>
				
				<div class="tab-pane fade" id="addnew">
					<form class="form-horizontal" role="form">
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
							<input type="text" class="form-control" id="inputCourse" placeholder="Course of Study">
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
							<select class="form-control" id="inputDate">
								<?php
								foreach ($arrivalDates AS $date) {
									echo "<option>" . date('l jS \of F Y', strtotime($date)) . "</option>";
								}
								?>
							</select>
							USE THIS TO SUGEST TO STUDENTS
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputTime">Time</label>
						<div class="col-lg-10">
							<select class="form-control" id="inputTime">
								<option>8:00 am</option>
								<option>8:00 am</option>
								<option>8:00 am</option>
								<option>8:00 am</option>
								<option>8:00 am</option>
								<option>8:00 am</option>
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
							<input class="form-control" type="checkbox" id="sendEmail" value="true">E-Mail candidate confirmation letter
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
						oversees / home / eu
						allow_feedback
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>