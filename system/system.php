<?php
session_start();
include("config.php");

//----------------------DO NOT EDIT ANYTHING BELOW THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING!!! ----------------------


/*
Function Name: db_retrieve
Parameters: $id - the identifier for the link to lookup
Returns: The link to be forwarded to
*/
function db_retrieve($id)
{
	$dbc = @mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS) or die("Cannot Connect to Server");
	@mysql_select_db(MYSQL_DB);
	
	
	$query = "SELECT redir_link FROM redirect_list WHERE id = '$id';";
	$result = mysql_query($query);
	
	while ($row = mysql_fetch_row($result))
	{
		foreach ($row as $field){$return_url = $field;}
	}
	
	return $return_url;
}

/*
Function Name: create_new_item
Parameters: $link_to - the URL to create an entry for
						$notes - any additional information about the link provided by the user
Returns: Nothing
*/
function create_new_item($link_to, $notes)
{
	$dbc = @mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS) or die("Cannot Connect to Server");
	@mysql_select_db(MYSQL_DB);
	
	//Check to make sure the item isn't currently in the database
	$query = "SELECT * FROM redirect_list WHERE redir_link='$link_to';";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) == 1) {
 		$item_exists_already = true;
	}
	else {
		$item_exists_already = false;
	}
	
	if($item_exists_already)
	{
		echo "<meta http-equiv=\"refresh\" content=\"0;url=admin.php?action=linkadderror\" />";
	}
	else
	{
		//Add the item if not exists
		$date_to_add = date("Y-m-d");
		$user_to_add = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
		$query = "INSERT INTO redirect_list(date, redir_link, notes, user) VALUES('$date_to_add', '$link_to', '$notes', '$user_to_add');";
		$result = mysql_query($query);
	}
}


/*
Function Name: delete_item
Parameters: $id - the id of the item to be deleted
Returns: Nothing
*/
function delete_item($id)
{
	$dbc = @mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS) or die("Cannot Connect to Server");
	@mysql_select_db(MYSQL_DB);
	
	$query = "DELETE FROM redirect_list WHERE id='$id';";
	$result = mysql_query($query);
	
}


/*
Function Name: add_user
Parameters: $first_name - the first name of the person to add
						$last_name - the last name of the person to add
						$email - the email address of the person to add
Returns: Nothing
*/
function add_user($first_name, $last_name, $email, $password)
{
	$dbc = @mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS) or die("Cannot Connect to Server");
	@mysql_select_db(MYSQL_DB);
	
	//Check to make sure the user isn't currently in the database
	$query = "SELECT * FROM user_list WHERE email='$email';";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) == 1) {
 		$user_exists_already = true;
	}
	else {
		$user_exists_already = false;
	}
	
	if($user_exists_already)
	{
		echo "<meta http-equiv=\"refresh\" content=\"0;url=admin.php?action=useradderror\" />";
	}
	else
	{
		//Add the item if not exists
		$query = "INSERT INTO user_list(first_name, last_name, password, email) VALUES('$first_name', '$last_name', '$password', '$email');";
		$result = mysql_query($query);
		
		//Notify user with email
		$message = "We are notifying you that a user account for Linkr was created for you. You may login at: " . $_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/")+1) . "admin.php. \n \n You may use the following information to login to your new account: \n Username: " . $email . "\nPassword: " . $password . " ";
		$from = "noreply@" . $_SERVER['HTTP_HOST'];
		mail($email,"Linkr Account Signup",$message, "From:" . $from);
	}
}


/*
Function Name: delete_user
Parameters: $id - the id of the user to delete
Returns: Nothing
*/
function delete_user($id)
{
	$dbc = @mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS) or die("Cannot Connect to Server");
	@mysql_select_db(MYSQL_DB);
	
	$query = "DELETE FROM user_list WHERE uid='$id';";
	$result = mysql_query($query);
}

/*
Function Name: check_login
Parameters: $entered_username - the username entered by the user
						$entered_password - the password entered by the user
Returns: Sets session variables
*/
function check_login($entered_username, $entered_password)
{
	$dbc = @mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS) or die("Cannot Connect to Server");
	@mysql_select_db(MYSQL_DB);

	//Check to see if user is in DB if they are, set session varilables, else don't and return nothing
	$query = "SELECT * FROM user_list WHERE email='$entered_username';";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) == 1) {
 		$user_exists_already = true;
	}
	else {
		$user_exists_already = false;
	}
	
	if($user_exists_already)
	{
		//Get password from the database and verify
		$password_query = "SELECT password FROM user_list WHERE email='$entered_username';";
		$password_result = mysql_query($password_query);
		
		while ($row = mysql_fetch_row($password_result))
		{
			foreach ($row as $field){$db_password = $field;}
		}
		
		$firstname_query = "SELECT first_name FROM user_list WHERE email='$entered_username';";
		$firstname_result = mysql_query($firstname_query);
		
		while ($row = mysql_fetch_row($firstname_result))
		{
			foreach ($row as $field){$first_name = $field;}
		}
		
		$lastname_query = "SELECT last_name FROM user_list WHERE email='$entered_username';";
		$lastname_result = mysql_query($lastname_query);
		
		while ($row = mysql_fetch_row($lastname_result))
		{
			foreach ($row as $field){$last_name = $field;}
		}
		
		
		if($entered_password == $db_password)
		{
			//Set session variables
			$_SESSION['firstname'] = $first_name;
			$_SESSION['lastname'] = $last_name;
			$_SESSION['email'] = $entered_username;
			$_SESSION['signedin'] = "yes";
		}
		else
		{
			return false;
		}
		//Return "yes"
		return true;
	}
	else
	{
		//Return "false"
		return false;
	}
	
}


/*
Function Name: getlinklist 
Parameters: None
Returns: Links in the database formatted in a standard table
*/
function getlinklist()
{
	$dbc = @mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS) or die("Cannot Connect to Server");
	@mysql_select_db(MYSQL_DB);

	//Check to see if user is in DB if they are, set session varilables, else don't and return nothing
	$query = "SELECT * FROM redirect_list ORDER BY id;";
	$result = mysql_query($query);
	
	echo "<table width=\"100%\" cellspacing=\"1\" border=\"1\"><tr><td><b>Redirect ID</b></td><td><b>Date Added</b></td><td><b>Redirecting To</b></td><td><b>Notes</b></td><td><b>Created By</b></td>";
	while($row = mysql_fetch_row($result)){
		echo"<tr>";
		foreach($row as $field){echo "<td>$field</td>";}
		echo "</tr>";
	}
}

function getuserlist()
{
	$dbc = @mysql_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS) or die("Cannot Connect to Server");
	@mysql_select_db(MYSQL_DB);

	//Check to see if user is in DB if they are, set session varilables, else don't and return nothing
	$query = "SELECT uid, first_name, last_name, email FROM user_list;";
	$result = mysql_query($query);
	
	echo "<table width=\"100%\" cellspacing=\"1\" border=\"1\"><tr><td><b>User ID</b></td><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Email</b></td>";
	while($row = mysql_fetch_row($result)){
		echo"<tr>";
		foreach($row as $field){echo "<td>$field</td>";}
		echo "</tr>";
	}
}


?>