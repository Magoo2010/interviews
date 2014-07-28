<?php
if (!isset($_SESSION['userinfo'][0]['samaccountname'][0])) {
	$redir = "Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?n=logon.php";
	header($redir);
	
	exit;
}
?>
<div class="row">
	<div class="page-header">
		<h1>Reports</h1>
	</div>
</div>



<?php
$confirmed = Students::find_all_confirmed();
$courses = Courses::find_all_in_use();

?>
<div class="row">
	<div class="col-lg-6">
		<h2>Candidates By Subject</h2>
		<form action="pdfreport.php?n=candidatesBySubject.php" method="post">
		<select class="multiselect" multiple="multiple" name="coursesSelected[]">
			<?php
			foreach ($courses AS $course) {
				$url = "pdfreport.php?n=candidatesBySubject.php&course=" . $course->uid;
				
				$output  = "<option value=\"" . $course->uid . "\">";
				$output .= $course->displayName();
				$output .= "</option>";
				
				echo $output;
			}
			?>
		</select>
		<br />
		<input type="submit" class="btn btn-primary btn-block" value="Candidates By Subject">
		</form>
		
		<h2>Other</h2>
		<a href="pdfreport.php?n=arrivals.php&orientation=L" class="btn btn-primary btn-block">Arrivals</a>
		<a href="pdfreport.php?n=disability.php" class="btn btn-primary btn-block">Disability Report</a>
		<a href="pdfreport.php?n=dietary.php" class="btn btn-primary btn-block">Dietary Report</a>
	</div>
	<div class="col-lg-6">
	</div>
</div>
 
<!-- Initialize the plugin: -->
<script type="text/javascript">
  $(document).ready(function() {
    $('.multiselect').multiselect();
  });
</script>