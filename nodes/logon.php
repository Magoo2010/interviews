<!-- Custom styles for this template -->
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
//you should look into using PECL filter or some form of filtering here for POST variables
if (isset($_POST["username"])) {
	$username = strtoupper($_POST["username"]); //remove case sensitivity on the username
	$password = $_POST["password"];
}

if (isset($_POST["oldform"])) { //prevent null bind

	if ($username != NULL && $password != NULL){
        try {
		    $adldap = new adLDAP();
        }
        catch (adLDAPException $e) {
            echo $e; 
            exit();   
        }
		
		//authenticate the user
		if ($adldap->authenticate($username, $password)){
			//establish your session and redirect
			
			$log = new Logs();
			$log->type = "info";
			$log->title = "LDAP User Logon";
			$log->description = $username . " logged on through LDAP";
			$log->create();
			
			session_start();
			$_SESSION["username"] = $username;
            $_SESSION["userinfo"] = $adldap->user()->info($username);
			$redir = "Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php";
			header($redir);
			exit;
		}
	}
	
	$message = "<div class=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>Warning!</strong> Login attempt failed.</div>";
}
?>

<div class="row">
	<div class="container">
		<form class="form-signin" id="loginForm" action="index.php?n=logon.php" method="post">
		<?php
		if (isset($message)) {
			echo $message;
		}
		?>
		<h2 class="form-signin-heading">Please sign in</h2>
		<input type="text" class="form-control" placeholder="Username" name="username" value="<?php if (isset($_POST['username'])) { echo $username; } ?>" autofocus>
		<input type="password" class="form-control" placeholder="Password" name="password">
		<button type="submit" class="btn btn-large btn-primary btn-block" >Sign in</button>
		<input type='hidden' name='oldform' value='1'>
		</form>
	</div>
</div>