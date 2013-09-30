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





<div class="row">
	<div class="col-lg-3">
		<div class="thumbnail">
			<img src="./img/300x200.png" alt="">
			<div class="caption">
				<h3>Candidates by Subject</h3>
				<p>(photo, and details, multiple per page)</p>
				<p><a href="pdfreport.php?n=candidatesBySubject.php" class="btn btn-primary btn-block">Generate Report</a></p>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="thumbnail">
			<img src="./img/300x200.png" alt="">
			<div class="caption">
				<h3>Disabilities</h3>
				<p>(photo, and details, multiple per page)</p>
				<p><a href="#" class="btn btn-primary btn-block">Generate Report</a></p>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="thumbnail">
			<img src="./img/300x200.png" alt="">
			<div class="caption">
				<h3>Special diet</h3>
				<p>(photo, and details, multiple per page)</p>
				<p><a href="#" class="btn btn-primary btn-block">Generate Report</a></p>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="thumbnail">
			<img src="./img/300x200.png" alt="">
			<div class="caption">
				<h3>Who has responded, of those, when are they arriving</h3>
				<p>(photo, and details, multiple per page)</p>
				<p><a href="#" class="btn btn-primary btn-block">Generate Report</a></p>
			</div>
		</div>
	</div>
</div>