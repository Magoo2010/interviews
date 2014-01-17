
<style>
.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="text"] {
  margin-bottom: -1px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>

<?php
if (SITE_STUDENT_LOGON == "true") {
?>
<div class="row">
	<div class="container">
		<form class="form-signin" id="loginForm" action="index.php" method="post">
		<?php
		if (isset($message)) {
			echo $message;
		}
		?>
		<h2 class="form-signin-heading">Please sign in</h2>
		<input type="text" class="form-control" placeholder="UCAS Number" name="inputUCAS" value="<?php if (isset($_POST['inputUCAS'])) { echo $_POST['inputUCAS']; } ?>" autofocus>
		<input type="text" class="form-control" placeholder="Surname" name="inputSurname">
		<p>Enter your UCAS number without spaces or punctuation</p>
		<button type="submit" class="btn btn-large btn-primary btn-block" >Sign in</button>
		<input type='hidden' name='oldform' value='1'>
		</form>
	</div>
	
	<p>Please note that an interview RSVP submitted using this website will not be accepted unless you have received an invitation from St Edmund Hall with explicit instructions to do so.</p>
	<p>If you have any problems with this site please email admissions@seh.ox.ac.uk</p>
</div>
<?php
} else {
?>
<div class="row">
	<div class="container">
		<form class="form-signin" id="loginForm" action="index.php" method="post">
		<h2 class="form-signin-heading">Site Closed</h2>
		</form>
	</div>
	
	<p>Please note that an interview RSVP submitted using this website will not be accepted unless you have received an invitation from St Edmund Hall with explicit instructions to do so.</p>
	<p>If you have any problems with this site please email admissions@seh.ox.ac.uk</p>
</div>
<?php
}
?>