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

// Build list of subjects
foreach ($confirmed AS $student) {
	$courseList[$student->course] = $student->course;
}
?>
<div class="row">
	<div class="col-lg-6">
		<div class="dropdown">
			<a data-toggle="dropdown" class="btn btn-primary btn-block" href="#">Candidates by Subject</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<?php
				foreach ($courseList AS $course) {
					$url = "pdfreport.php?n=candidatesBySubject.php&course=" . $course;
					
					$output  = "<li>";
					$output .= "<a href=\"" . $url . "\">";
					$output .= $course;
					$output .= "</a>";
					$output .= "</li>";
					
					echo $output;
				}
				?>
			</ul>
		</div>
		
		<a href="pdfreport.php?n=arrivals.php&orientation=L" class="btn btn-primary btn-block">Arrivals</a>
	</div>
	<div class="col-lg-6">
	</div>
</div>