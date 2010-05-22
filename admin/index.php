<?php
session_start(); 
include("../system/system.php");

if($_SESSION['loggedin'] == "yes")
{
	echo "<meta http-equiv=\"refresh\" content=\"3;url=admin.php\" />";
}
else if($_GET['reason'] == "login_error")
{
	?>
		<center>
			<table border="0" width="300">
				<tr><td>
				<fieldset>
					<legend>Log In</legend>

					<form name="login" action="admin.php?action=verifylogin" method="POST">
						<table border="0">
							<img src="../system/images/linkr_logo.jpg" alt="logo">
							<center><strong>There was an error processing your login. Ensure you typed your username and password correctly.</strong></center>
							<tr><td>Username:</td><td><input name="username" type="text" length="30" maxlength="31"></td></tr>
							<tr><td>Password:</td><td><input name="password" type="password" length="30" maxlength="31"></td></tr>
							<tr><td></td><td><input type="submit" value="Login"></td></tr>
						</table>
					</form>
					</fieldset>
					</td></tr>
			</table>
		</center>
	
	<?php
}
else{
?>

<center>
	<table border="0" width="300">
		<tr><td>
		<fieldset>
			<legend>Log In</legend>
		
			<form name="login" action="admin.php?action=verifylogin" method="POST">
				<img src="../system/images/linkr_logo.jpg" alt="logo">
				<table border="0">
					<center>
					<tr><td>Username:</td><td><input name="username" type="text" length="30" maxlength="31"></td></tr>
					<tr><td>Password:</td><td><input name="password" type="password" length="30" maxlength="31"></td></tr>
					<tr><td></td><td><input type="submit" value="Login"></td></tr>
					</center>
				</table>
			</form>
			</fieldset>
			</td></tr>
	</table>
</center>

<?php
}
?>