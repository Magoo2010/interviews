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
$courses = Courses::find_all();

?>
<div class="row">
	<div class="col-lg-6">
		<div class="dropdown">
			<a data-toggle="dropdown" class="btn btn-primary btn-block" href="#">Candidates by Subject</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<?php
				foreach ($courses AS $course) {
					$url = "pdfreport.php?n=candidatesBySubject.php&course=" . $course->uid;
					
					$output  = "<li>";
					$output .= "<a href=\"" . $url . "\">";
					$output .= $course->displayName();
					$output .= "</a>";
					$output .= "</li>";
					
					echo $output;
				}
				?>
			</ul>
		</div>
		
		<a href="pdfreport.php?n=arrivals.php&orientation=L" class="btn btn-primary btn-block">Arrivals</a>
		<a href="pdfreport.php?n=disability.php" class="btn btn-primary btn-block">Disability Report</a>
		<a href="pdfreport.php?n=dietary.php" class="btn btn-primary btn-block">Dietary Report</a>
	</div>
	<div class="col-lg-6">
	</div>
</div>