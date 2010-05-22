<?php
session_start();
include("../system/system.php");

$action = $_GET['action'];

if($_SESSION['signedin'] != "yes")
{
	if($action == "verifylogin")
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
	
		$correct = check_login($username, $password);
	
		if($correct)
		{
			echo "<meta http-equiv=\"refresh\" content=\"0;url=admin.php\" />";
		}
		else
		{
			echo "<meta http-equiv=\"refresh\" content=\"0;url=index.php?reason=login_error\" />";
		}
	}
}
	
if($_SESSION['signedin'] == "yes")
{
	if($action == "useradderror")
	{
		echo "<center><table border=\"0\" width=\"600\"><tr><td><img src=\"../system/images/linkr_logo.jpg\" alt=\"logo\" width=\"100\" height=\"70\"> &nbsp; &nbsp; <a href=\"admin.php\">Link Management</a> <a href=\"admin.php?action=users\">User Management</a> <a href=\"admin.php?action=logout\">Logout</a>";
		echo "<fieldset><legend>Add a User</legend>";
		echo "<strong>The user you are trying to add already exists. Please see user list below.</strong> <br /><br /> <form name=\"adduser\" action=\"admin.php?action=adduser\" method=\"POST\"><table border=\"0\"><tr><td>First Name: </td><td><input name=\"firstname\" type=\"text\"></td></tr><tr><td>Last Name: </td><td> <input name=\"lastname\" type=\"text\"></td><tr><td>Email: </td><td> <input name=\"email\" type=\"text\"></td></tr><tr><td>Password: </td><td> <input name=\"password\" type=\"password\"></td><tr><td></td><td><input type=\"submit\" value=\"Add User\"></form></table>";
		echo "</fieldset><fieldset><legend>Delete a User</legend>";
		echo "<form name=\"deleteuser\" action=\"admin.php?action=deleteuser\" method=\"POST\"><table border=\"0\"><tr><td>ID to delete: </td><td><input name=\"usertodelete\" type=\"text\"></td></tr><tr><td></td><td><input type=\"submit\" value=\"Delete User\"></form></table>";
		echo "</fieldset><fieldset><legend>Current Users</legend>";
		getuserlist();
		echo "</fieldset>";
		echo "</td></tr></table></center>";
	}
	else if($action == "users")
	{
		echo "<center><table border=\"0\" width=\"600\"><tr><td><img src=\"../system/images/linkr_logo.jpg\" alt=\"logo\" width=\"100\" height=\"70\"> &nbsp; &nbsp; <a href=\"admin.php\">Link Management</a> <a href=\"admin.php?action=users\">User Management</a> <a href=\"admin.php?action=logout\">Logout</a>";
		echo "<fieldset><legend>Add a User</legend>";
		echo "<form name=\"adduser\" action=\"admin.php?action=adduser\" method=\"POST\"><table border=\"0\"><tr><td>First Name: </td><td><input name=\"firstname\" type=\"text\"></td></tr><tr><td>Last Name: </td><td> <input name=\"lastname\" type=\"text\"></td><tr><td>Email: </td><td> <input name=\"email\" type=\"text\"></td></tr><tr><td>Password: </td><td> <input name=\"password\" type=\"password\"></td><tr><td></td><td><input type=\"submit\" value=\"Add User\"></form></table>";
		echo "</fieldset><fieldset><legend>Delete a User</legend>";
		echo "<form name=\"deleteuser\" action=\"admin.php?action=deleteuser\" method=\"POST\"><table border=\"0\"><tr><td>ID to delete: </td><td><input name=\"usertodelete\" type=\"text\"></td></tr><tr><td></td><td><input type=\"submit\" value=\"Delete User\"></form></table>";
		echo "</fieldset><fieldset><legend>Current Users</legend>";
		getuserlist();
		echo "</fieldset>";
		echo "</td></tr></table></center>";
	}
	else if($action == "adduser")
	{
		$first_name = $_POST['firstname'];
		$last_name = $_POST['lastname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		add_user($first_name, $last_name, $email, $password);
		
		echo "<center><table border=\"0\" width=\"600\"><tr><td><img src=\"../system/images/linkr_logo.jpg\" alt=\"logo\" width=\"100\" height=\"70\"> &nbsp; &nbsp; <a href=\"admin.php\">Link Management</a> <a href=\"admin.php?action=users\">User Management</a> <a href=\"admin.php?action=logout\">Logout</a>";
		echo "<fieldset><legend>Add a User</legend>";
		echo "<form name=\"adduser\" action=\"admin.php?action=adduser\" method=\"POST\"><table border=\"0\"><tr><td>First Name: </td><td><input name=\"firstname\" type=\"text\"></td></tr><tr><td>Last Name: </td><td> <input name=\"lastname\" type=\"text\"></td><tr><td>Email: </td><td> <input name=\"email\" type=\"text\"></td></tr><tr><td>Password: </td><td> <input name=\"password\" type=\"password\"></td><tr><td></td><td><input type=\"submit\" value=\"Add User\"></form></table>";
		echo "</fieldset><fieldset><legend>Delete a User</legend>";
		echo "<form name=\"deleteuser\" action=\"admin.php?action=deleteuser\" method=\"POST\"><table border=\"0\"><tr><td>ID to delete: </td><td><input name=\"usertodelete\" type=\"text\"></td></tr><tr><td></td><td><input type=\"submit\" value=\"Delete User\"></form></table>";
		echo "</fieldset><fieldset><legend>Current Users</legend>";
		getuserlist();
		echo "</fieldset>";
		echo "</td></tr></table></center>";
	}
	else if($action == "deleteuser")
	{
		$user_to_delete = $_POST['usertodelete'];
		
		delete_user($user_to_delete);
		
		echo "<center><table border=\"0\" width=\"600\"><tr><td><img src=\"../system/images/linkr_logo.jpg\" alt=\"logo\" width=\"100\" height=\"70\"> &nbsp; &nbsp; <a href=\"admin.php\">Link Management</a> <a href=\"admin.php?action=users\">User Management</a> <a href=\"admin.php?action=logout\">Logout</a>";
		echo "<fieldset><legend>Add a User</legend>";
		echo "<form name=\"adduser\" action=\"admin.php?action=adduser\" method=\"POST\"><table border=\"0\"><tr><td>First Name: </td><td><input name=\"firstname\" type=\"text\"></td></tr><tr><td>Last Name: </td><td> <input name=\"lastname\" type=\"text\"></td><tr><td>Email: </td><td> <input name=\"email\" type=\"text\"></td></tr><tr><td>Password: </td><td> <input name=\"password\" type=\"password\"></td><tr><td></td><td><input type=\"submit\" value=\"Add User\"></form></table>";
		echo "</fieldset><fieldset><legend>Delete a User</legend>";
		echo "<form name=\"deleteuser\" action=\"admin.php?action=deleteuser\" method=\"POST\"><table border=\"0\"><tr><td>ID to delete: </td><td><input name=\"usertodelete\" type=\"text\"></td></tr><tr><td></td><td><input type=\"submit\" value=\"Delete User\"></form></table>";
		echo "</fieldset><fieldset><legend>Current Users</legend>";
		getuserlist();
		echo "</fieldset>";
		echo "</td></tr></table></center>";	
	}
	else if($action == "addlink")
	{
		$url_to_add = $_POST['url'];
		$notes_to_add = $_POST['notes'];
	
		create_new_item($url_to_add, $notes_to_add);
	
		echo "<center><table border=\"0\" width=\"600\"><tr><td><img src=\"../system/images/linkr_logo.jpg\" alt=\"logo\" width=\"100\" height=\"70\"> &nbsp; &nbsp; <a href=\"admin.php\">Link Management</a> <a href=\"admin.php?action=users\">User Management</a> <a href=\"admin.php?action=logout\">Logout</a>";
		echo "<fieldset><legend>Add a Link</legend>";
		echo "<form name=\"addlink\" action=\"admin.php?action=addlink\" method=\"POST\"><table border=\"0\"><tr><td>URL: </td><td><input name=\"url\" type=\"text\"></td></tr><tr><td>Notes: </td><td> <input name=\"notes\" type=\"text\"></td></tr><tr><td></td><td><input type=\"submit\" value=\"Add Link\"></form></table>";
		echo "</fieldset><fieldset><legend>Delete a Link</legend>";
		echo "<form name=\"deletelink\" action=\"admin.php?action=deletelink\" method=\"POST\"><table border=\"0\"><tr><td>ID to delete: </td><td><input name=\"idtodelete\" type=\"text\"></td></tr><tr><td></td><td><input type=\"submit\" value=\"Delete Link\"></form></table>";
		echo "</fieldset><fieldset><legend>Current Links</legend>";
		getlinklist();
		echo "</fieldset>";
		echo "</td></tr></table></center>";
	}
	else if($action == "deletelink")
	{
		$link_to_delete = $_POST['idtodelete'];
	
		delete_item($link_to_delete);
	
		echo "<center><table border=\"0\" width=\"600\"><tr><td><img src=\"../system/images/linkr_logo.jpg\" alt=\"logo\" width=\"100\" height=\"70\"> &nbsp; &nbsp; <a href=\"admin.php\">Link Management</a> <a href=\"admin.php?action=users\">User Management</a> <a href=\"admin.php?action=logout\">Logout</a>";
		echo "<fieldset><legend>Add a Link</legend>";
		echo "<form name=\"addlink\" action=\"admin.php?action=addlink\" method=\"POST\"><table border=\"0\"><tr><td>URL: </td><td><input name=\"url\" type=\"text\"></td></tr><tr><td>Notes: </td><td> <input name=\"notes\" type=\"text\"></td></tr><tr><td></td><td><input type=\"submit\" value=\"Add Link\"></form></table>";
		echo "</fieldset><fieldset><legend>Delete a Link</legend>";
		echo "<form name=\"deletelink\" action=\"admin.php?action=deletelink\" method=\"POST\"><table border=\"0\"><tr><td>ID to delete: </td><td><input name=\"idtodelete\" type=\"text\"></td></tr><tr><td></td><td><input type=\"submit\" value=\"Delete Link\"></form></table>";
		echo "</fieldset><fieldset><legend>Current Links</legend>";
		getlinklist();
		echo "</fieldset>";
		echo "</td></tr></table></center>";
	}
	else if($action == "logout")
	{
		session_destroy();
		echo "<meta http-equiv=\"refresh\" content=\"0;url=index.php\" />";
	}
	else
	{
		echo "<center><table border=\"0\" width=\"600\"><tr><td><img src=\"../system/images/linkr_logo.jpg\" alt=\"logo\" width=\"100\" height=\"70\"> &nbsp; &nbsp; <a href=\"admin.php\">Link Management</a> <a href=\"admin.php?action=users\">User Management</a> <a href=\"admin.php?action=logout\">Logout</a>";
		echo "<fieldset><legend>Add a Link</legend>";
		echo "<form name=\"addlink\" action=\"admin.php?action=addlink\" method=\"POST\"><table border=\"0\"><tr><td>URL: </td><td><input name=\"url\" type=\"text\"></td></tr><tr><td>Notes: </td><td> <input name=\"notes\" type=\"text\"></td></tr><tr><td></td><td><input type=\"submit\" value=\"Add Link\"></form></table>";
		echo "</fieldset><fieldset><legend>Delete a Link</legend>";
		echo "<form name=\"deletelink\" action=\"admin.php?action=deletelink\" method=\"POST\"><table border=\"0\"><tr><td>ID to delete: </td><td><input name=\"idtodelete\" type=\"text\"></td></tr><tr><td></td><td><input type=\"submit\" value=\"Delete Link\"></form></table>";
		echo "</fieldset><fieldset><legend>Current Links</legend>";
		getlinklist();
		echo "</fieldset>";
		echo "</td></tr></table></center>";
	}
}
else
{
	echo "<center>";
		echo "<table border=\"0\" width=\"300\">";
			echo "<tr><td>";
			echo "<fieldset>";
				echo "<legend>Not Authorized</legend>";
				echo "<strong>You are not authorized to view this page. Please trying <a href=\"index.php\">logging in</a>.";
			echo "</fieldset>";
			echo "</td></tr>";
		echo "</table>";
	echo "</center>";
}
?>