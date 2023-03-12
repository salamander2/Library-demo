<?php
session_start();
require_once('common.php');

//TODO: shouldn't username be set to "" no matter what?
if (isset($username)){
	$username = "";
	$_SESSION["username"] = "";
}

//TODO: Add in a connect time, that's udpdated for every action. If the connect time is more than 6 hours old, logout the user.

$db = connectToDB();

$error_message = "";

/**** LOGIN LOGIC *******/
// This also logs in the administrative user. There must be a user registered with the name "adminnimda" and a proper password
// When this user logs on, then the program redirects to the main_admin page and sets a flag that the admin is logged in.

if(isset($_POST['submit'])) {
	$username = clean_input($_POST['username']);
	$password = $_POST["password"];

	//check password for that user
	$sql = "SELECT password, fullname FROM users WHERE username = BINARY ?";
	if ($stmt = $db->prepare($sql)) {
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->execute();
		$stmt->bind_result($pwdHash, $fullname);
		$stmt->fetch(); //needed to actually get the result for binding
		$stmt->close();
	} else {
		$message_  = 'Invalid query: ' . mysqli_error($db) . "\n<br>";
		$message_ .= 'SQL: ' . $sql;
		die($message_);
	}
	// die(var_dump($result));
	// die($pwdHash);
	$row_cnt = mysqli_num_rows($result);
	// die($row_cnt);
	if (0 === $row_cnt) {		
		$error_message = "That user does not exist. <br>(Check case of username or talk to admin.)";
	} elseif (!password_verify ($password, $pwdHash )) {
		$error_message = "Invalid password";
	}
	$password = "---";
	
	// error message ...
	if ($error_message != "") $error_message = '<div class="alert text-white bg-danger mt-3"><b> '. $error_message .' </b></div>';
	if (empty($error_message)) {
		$_SESSION["username"] = $username;
		$_SESSION["fullname"] = $fullname;
		//This is set here upon login (AND ALSO IN register.php)  and then session-authkey is never set again.
		$_SESSION["authkey"] = AUTHKEY;

		//Update last login timestamp
		$sql = "UPDATE users set lastLogin=NOW() WHERE username = BINARY ?";
		if ($stmt = $db->prepare($sql)) {
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$stmt->close();
		} else {
			$message_  = 'Invalid query: ' . mysqli_error($db) . "\n<br>";
			$message_ .= 'SQL: ' . $sql;
			die($message_);
		}

		if ($username == ADMINUSER) {
			header('Location:adminMain.php');
		} else {
			header('Location:main.php');
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>WebDev Project: Library Database</title>
 <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="resources/bootstrap-5.2.3-dist/css/bootstrap.min.css" >
</head>

<body>
	<!-- This form will call either login.php or register.php with the same fields. -->
	<script>
		function validateData() {
			var x, text;
			x = document.getElementById("username").value;
			if (!x || 0 === x.length) {
				text = "You must include a username";
				//text = "<div class=\"error\">" + text + "</div>";
				document.getElementById("error_message").outerHTML =
					'<div id="error_message" class="alert alert-danger w-50"></div>';
				document.getElementById("username").outerHTML =
					'<input type="text" name="username" id="username"  class="form-control border-danger" placeholder="Username">';
				document.getElementById("error_message").innerHTML = text;
				document.getElementById("username").value = "";
				return false;
			}
			x = document.getElementById("password").value;
			if (!x || 0 === x.length) {
				text = "You must include a password";
				//text = "<div class=\"error\">" + text + "</div>";
				document.getElementById("error_message").outerHTML =
					'<div id="error_message" class="alert alert-danger w-50 "></div>';
				document.getElementById("password").outerHTML =
					'<input type="password" name="password" id="password" class="form-control border-danger" placeholder="Password">';
				document.getElementById("error_message").innerHTML = text;
				document.getElementById("password").value = "";
				return false;
			}

			return true;
		}
	</script>

<div class="container-md mt-2">
	<h2 class="bg-warning text-center rounded py-3">The GHOSTS Public Libary</h2>

&nbsp;

	<div class="row">
	<div class="col-md-8">
	<div class="card border border-primary p-2">
		<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" onsubmit="return validateData()">
		<div class="alert alert-warning">Sign in</div>
		<!-- <div class="input-group mb-3"> -->
		<div class="row">
			<div class="col-4">
				<input type="text" name="username" id="username" class="form-control" placeholder="Username" >
			</div>
			<div class="col-4">
				<input type="password" name="password" id="password" class="form-control" placeholder="Password">
			</div>
			<div class="col-md-2">
			<!--<div class="col-lg-2 col-md-4 col-12 mt-1"> -->
				<button type="submit" name="submit" class="btn btn-primary">
					Login
				</button>
			</div>
		</div>
		</form>
		</div>
	</div>
	<div class="col-3 offset-1"><img width=200 height=170 src="images/ghost.png">
	</div>
	</div>
	<div id="error_message"></div>
	<?php if ($error_message != "") echo $error_message; ?>
&nbsp;

	<div class="card border border-secondary alert alert-warning">
		<div class="card-body">
<!-- SEARCH FORM -->
    <div class="ml-3">
        <fieldset>
            <b>Search:</b> <input size=35 id="inputName" type="text" onkeyup="findPatron(this.value)" onkeydown="if (event.keyCode === 27) resetTerminal();"
            placeholder="Enter Patron last name, phone, or barcode">
		<span class="float-end"><a href="addPatron.php"><button type="button" class="btn btn-success">Add Patron</button></a></span>
        </fieldset>
		<p><i>This does not work yet</i></p>
    </div>

&nbsp;
			<p class="">* <a href="listPatron1.php">List all Patrons</a><br>
			Here's our initial list patron page. Eventually, it will pop up from the search bar above.</p>
			<p class="">* <a href="">Edit a Patron</a><br>
			(This will normally be accessed by clicking on a patron from the listing above.)<br>
			(This page will show the patron information and allow editing (update) or deletion. Upon deletion it will return here.)</p>

		</div><!-- /card-body -->
	</div><!-- /card -->

</div>
</body>

</html>
