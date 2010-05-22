<?php
session_start();

$step = $_GET['step'];

if($step == "")
{
	echo "<center><img src=\"../../system/images/linkr_logo.jpg\" alt=\"logo\"><br /><table border=\"0\" width=\"400\"><tr><td><fieldset><legend>Step 1</legend>";
	echo "Please specify the following information to setup the MySQL database to work with Linkr. <br /><br /> <form name=\"step1\" action=\"index.php?step=2\" method=\"POST\"><table border=\"0\"><tr><td>MySQL Server: </td><td><input name=\"server\" type=\"text\"></td></tr><tr><td>MySQL Username: </td><td><input name=\"user\" type=\"text\"></td></tr><tr><td>MySQL Password: </td><td><input name=\"password\" type=\"password\"></td></tr><tr><td>MySQL Database Name: </td><td><input name=\"db\" type=\"text\"></td></tr>";
	echo "<tr><td></td><td><input type=\"submit\" value=\"Continue >\"></td></tr></table></form></center></table>";
}
else if($step == "2")
{
	$_SESSION['server'] = $_POST['server'];
	$_SESSION['user'] = $_POST['user'];
	$_SESSION['password'] = $_POST['password'];
	$_SESSION['db'] = $_POST['db'];
	
	//Connect and Create DB Tables
	$dbc = @mysql_connect($_SESSION['server'], $_SESSION['user'], $_SESSION['password']) or die("Cannot Connect to Server");
	@mysql_select_db($_SESSION['db']);

	$query1 = "CREATE TABLE redirect_list(id int NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), date varchar(30) NOT NULL, redir_link varchar(1000), notes varchar(1000) NOT NULL, user varchar(30) NOT NULL);";
	$result = mysql_query($query1);
	
	$query2 = "CREATE TABLE user_list(uid int NOT NULL AUTO_INCREMENT, PRIMARY KEY(uid), first_name varchar(30), last_name varchar(30) NOT NULL, password varchar(50) NOT NULL, email varchar(100) NOT NULL);";
	$result = mysql_query($query2);
	
	//Ask for Admin User
	echo "<center><img src=\"../../system/images/linkr_logo.jpg\" alt=\"logo\"><br /><table border=\"0\" width=\"400\"><tr><td><fieldset><legend>Step 2</legend>";
	echo "Please specify a starting administrator account. <br /><br /> <form name=\"step2\" action=\"index.php?step=3\" method=\"POST\"><table border=\"0\"><tr><td>First Name: </td><td><input name=\"firstname\" type=\"text\"></td></tr><tr><td>Last Name: </td><td><input name=\"lastname\" type=\"text\"></td></tr><tr><td>Password: </td><td><input name=\"password\" type=\"password\"></td></tr><tr><td>Email Address: </td><td><input name=\"email\" type=\"text\"></td></tr>";
	echo "<tr><td></td><td><input type=\"submit\" value=\"Continue >\"></td></tr></table></form></center></table>";
}
else if($step == "3")
{
	$dbc = @mysql_connect($_SESSION['server'], $_SESSION['user'], $_SESSION['password']) or die("Cannot Connect to Server");
	@mysql_select_db($_SESSION['db']);
	
	$first_name = $_POST['firstname'];
	$last_name = $_POST['lastname'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	
	$query = "INSERT INTO user_list(first_name, last_name, password, email) VALUES('$first_name', '$last_name', '$password', '$email');";
	$result = mysql_query($query);
	
	session_destroy();
	mysql_close($dbc);
	
	//Notify user with email
	$message = "We are notifying you that a user account for Linkr was created for you. You may login at: " . $_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/")+1) . "admin.php. \n \n You may use the following information to login to your new account: \n Username: " . $email . "\nPassword: " . $password . " ";
	$from = "noreply@" . $_SERVER['HTTP_HOST'];
	mail($email,"Linkr Account Signup",$message, "From:" . $from);
	
	echo "<center><img src=\"../../system/images/linkr_logo.jpg\" alt=\"logo\"><br /><table border=\"0\" width=\"400\"><tr><td><fieldset><legend>Finished</legend>";
	echo "Your account has been set up and you're now able to login to your Linkr account. <br /><br /> You should now remove the \"install\" directory from your linker directory for security reasons. <br /> <br /> <a href=\"../../admin/\">Go to Admin Login</a></center></table>";
}
?>