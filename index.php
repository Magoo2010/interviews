<?php
include_once("engine/initialise.php");
?>
<?php
//log them out?
if (isset($_GET['logout'])) {
	if ($_GET['logout'] == true) { //destroy the session
		$_SESSION = array();
		$_SESSION['username'] = null;
		session_destroy();
		
		$message = "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>Success!</strong> You have been logged out.</div>";
	}
}

//you should look into using PECL filter or some form of filtering here for POST variables
if (isset($_POST["inputUCAS"])) {
	$ucas = $_POST["inputUCAS"];
	$surname = strtoupper($_POST["inputSurname"]); //remove case sensitivity on the surname
	
	echo "logging in with " . $ucas;
	
	if ($ucas != NULL && $surname != NULL) {
		//authenticate the user
		$user = Students::logon($surname, $ucas);
		
		if ($user) {
			$log = new Logs();
			$log->type = "info";
			$log->title = "User Logon";
			$log->description = $user->fullDisplayName() . " logged on";
			$log->userUID = $user->uid;
			$log->create();
			
			//establish your session and redirect
			session_start();
			$_SESSION["username"] = $user->ucas;
			$_SESSION["localUID"] = $user->uid;
			
			$redir = "Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?m=students&n=user.php&studentUID=" . $user->uid;
			header($redir);
			exit;
		} else {
			$message = "<div class=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>Warning!</strong> Login attempt failed.</div>";
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include_once("views/html_head.php"); ?>
<style>
body {
	margin-top: 60px;
}
</style>
<body>
	<?php
	include_once("views/navigation.php");
	
	if (!isset($_GET['m']) && !isset($_GET['n'])) {
		include_once("views/hero.php");
	}
	?>
	<div class="container">
		<?php
		if (isset($_GET['m'])) {
			$fileInclude = "modules/" . $_GET['m'] . "/nodes/" . $_GET['n'];
		} elseif(isset($_GET['n'])) {
			$fileInclude = "nodes/" . $_GET['n'];
		} else {
			$fileInclude = "nodes/index.php";
		}
		
		
		if (!isset($_SESSION['username'])) {
			//$fileInclude = "nodes/ucas_logon.php";
			// we're not logged in - are we trying to get to the admin logon or contact page?
			if (isset($_GET['n'])) {
				if ($_GET['n'] == "logon.php") {
					$fileInclude = "nodes/logon.php";
				} elseif ($_GET['n'] == "contact.php") {
					$fileInclude = "nodes/contact.php";
				} else {
					$fileInclude = "nodes/ucas_logon.php";
				}
			} else {
				$fileInclude = "nodes/ucas_logon.php";
			}
		}
		include_once($fileInclude);
		?>
		<?php include_once("views/footer.php"); ?>
	</div>
</body>
</html>

<?php
//navigation quick search
$allStudents = Students::find_all();

if (count($allStudents) > 0) {
	foreach ($allStudents AS $student) {
		$name = str_replace("'", "", $student->fullDisplayName());
		//$name = htmlspecialchars($name, ENT_QUOTES);
		
		$searchOutput[] = "{id: " . $student->uid . ", name: '" . $name . "'}";
	}
}
?>
<script>
/*
$(document).ready(function() {
	var usersAhead = [<?php echo implode(",", $searchOutput);?>];
	
	$('#searchAhead').typeahead({
		source: usersAhead,
		matchProp: 'name',
		sortProp: 'name',
		valueProp: 'id',
		itemSelected: function (item) {
			// go to user_overview.php and pass the userUID var in the $_GET
			location.href = "index.php?m=students&n=user.php&studentUID=" + item
		}
	});
});
*/
</script>