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
		<button type="submit" class="btn btn-large btn-primary btn-block" >Sign in</button>
		<input type='hidden' name='oldform' value='1'>
		</form>
	</div>
	
	<p>Please note that a booking using this website will not be accepted unless you have had explicit instructions from St Edmund Hall to do so.</p>
	<p>If you have any problems with this site please email admissions@seh.ox.ac.uk</p>
</div>