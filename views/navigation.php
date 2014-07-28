<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">St. Edmund Hall</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="index.php">Home</a></li>
				<?php
				if (isset($_SESSION['userinfo'])) {
					echo "<li><a href=\"index.php?m=students&n=index.php\">Students</a></li>";
				} else {
					echo "<li><a href=\"index.php?m=students&n=user.php&studentUID=" . $_SESSION['localUID'] . "\">My Details</a></li>";
				}
				?>
				
				<li><a href="index.php?n=contact.php">Contact</a></li>
			</ul>
			<!--<form class="navbar-form navbar-left" role="search" method="post" action="node.php?m=search/views/search_results.php">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search" name="quickSearchTerm">
				</div
			</form>>-->
			<ul class="nav navbar-nav pull-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?n=logon.php">Admin. Logon</a></li>
						<li><a href="index.php?m=courses&n=index.php">Courses</a></li>
						<li><a href="index.php?m=reports&n=index.php">Reports</a></li>
						<li><a href="index.php?m=settings&n=email_admin.php">E-Mail Settings</a></li>
						<li><a href="index.php?m=logs&n=index.php">Activity Logs</a></li>
						<li class="divider"></li>
						<li><a href="index.php?n=ucas_logon.php&logout=true">Log Out</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>