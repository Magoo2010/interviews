<?php
include_once("engine/initialise.php");
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
			$fileInclude = "nodes/ucas_logon.php";
			// we're not logged in - are we trying to get to the admin logon or contact page?
			if (isset($_GET['n'])) {
				if ($_GET['n'] == "logon.php") {
					$fileInclude = "nodes/logon.php";
				} elseif ($_GET['n'] == "contact.php") {
					$fileInclude = "nodes/contact.php";
				} else {
					
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
</script>