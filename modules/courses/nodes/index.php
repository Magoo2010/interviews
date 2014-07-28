<?php
if (!isset($_SESSION['userinfo'][0]['samaccountname'][0])) {
	$redir = "Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?n=logon.php";
	header($redir);
	
	exit;
}
?>
<div class="row">
	<div class="page-header">
		<h1>Courses</h1>
	</div>
</div>



<?php
$courses = Courses::find_all_in_use();

?>

<div class="row">
<table class="table table-striped">
	<thead>
		<tr>
		<th>Course Code</th>
		<th>Course Name</th>
		<th>Interview Start Date</th>
		</tr>
	</thead>
	<tbody>
		
		<?php
		foreach ($courses AS $course) {
			$output  = "<tr>";
			$output .= "<td>" . "<a href=\"#\" id=\"code\" class=\"editable\" data-type=\"text\" data-pk=\"" . $course->uid . "\" data-url=\"modules/courses/actions/update.php\" data-title=\"Enter Course Code\">" . $course->code . "</a></td>";
			$output .= "<td>" . "<a href=\"#\" id=\"name\" class=\"editable\" data-type=\"text\" data-pk=\"" . $course->uid . "\" data-url=\"modules/courses/actions/update.php\" data-title=\"Enter Course Name\">" . $course->name . "</a></td>";
			$output .= "<td>" . "<a href=\"#\" id=\"interview_startdate\" class=\"editable\" data-type=\"date\" data-pk=\"" . $course->uid . "\" data-url=\"modules/courses/actions/update.php\" data-title=\"Enter Interview Start Date\">" . $course->interview_startdate . "</a></td>";
			$output .= "</tr>";
			
			echo $output;
		}
		?>
	</tbody>
</table>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('.editable').editable();
});
</script>