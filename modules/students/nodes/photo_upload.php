<?php
$user = Students::find_by_uid($_GET['studentUID']);

if (isset($_FILES['fileInput']['name'])) {
	$target_path = SITE_LOCATION . '/uploads/';
	$target_name = $user->uid . "_" . basename($_FILES['fileInput']['name']);
	$target_path_name = $target_path . $target_name; 
	
	if(move_uploaded_file($_FILES['fileInput']['tmp_name'], $target_path_name)) {
		// file uploaded!
		$user->photograph = $target_name;
		
		$messageOutput  = "<div class=\"alert alert-success\">";
		$messageOutput .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
		$messageOutput .= "<strong>Success!</strong> ";
		$messageOutput .= "The file '" . basename( $_FILES['fileInput']['name']) . "' has been uploaded and linked to UID: " . $user->uid;
		$messageOutput .= "</div>";	
	} else{
		// error uploading file
		
		$messageOutput  = "<div class=\"alert alert-danger\">";
		$messageOutput .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
		$messageOutput .= "<strong>Error!</strong> ";
		$messageOutput .= "There was an error uploading the file '" . basename( $_FILES['fileInput']['name']) . "', please try again!";
		$messageOutput .= "</div>";	
	}
}
?>

<div class="container">
	<div class="row">
		<div class="page-header">
			<h1>Upload Photograph <small> images/pdf/zip/reg/doc/etc</small></h1>
		</div>
		<?php
		if (isset($messageOutput)) {
			echo $messageOutput;
		} ?>
		<form class="form-horizontal" id="addToRemoveForm" method="post" action="index.php?m=students&n=photo_upload.php&studentUID=<?php echo $user->uid; ?>" enctype="multipart/form-data">
		<fieldset>
			<legend>Upload Photograph</legend>
			<div class="control-group">
				<label class="control-label" for="fileInput">File</label>
				<div class="controls">
					<input class="input-file" id="fileInput" name="fileInput" type="file">
				</div>
			</div>
			<div class="form-actions">
				<input type="submit" class="btn btn-large btn-primary" id="test" value="Begin Upload" />
			</div>
		</fieldset>
		</form>
	</div>
</div>
