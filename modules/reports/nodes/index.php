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
	<div class="col-lg-12">
		<ul>
			<li><a href="pdfreport.php?n=candidatesBySubject.php">Candidates by Subject</a></li>
			<li><a href="pdfreport.php?n=arrivals.php&orientation=L">Arrivals</a></li>
		</ul>
	</div>
</div>