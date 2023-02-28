<?php

/* listPatron.php
   This program shows how we can list patrons.
   It demonstrates how to use php to access MySQL
   It is a demo program and so is not actually called from anywhere
*/

/* Session variables -- these are not implemented yet since there is no logon mechanism programmed yet.
	$username	- the user's login name
	$fullname	- the user's full name
	$isAdmin	- the user is admin  (vs normal user). How do we designate a read only user?	
*/

session_start();

# common.php has a set of common utility methods. 
# It also sets the Error reporting (to /var/log/apache2/error.log)
# It sets various session variables if they are not already set.
# and it links to config.php which has the variables needed to log in to MySQL.
require_once('common.php');

$db = connectToDB();

# This is a basic SQL select statement. 
$sql = "SELECT * FROM patron ORDER BY city, lastname LIMIT 50";
$result = runSimpleQuery($db, $sql);
#$response = mysqli_fetch_all($result);

# PHP methods go here

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Demonstration page </title>
</head>

<style>
table, th, td {
  border: 1px solid gray;
  border-collapse: collapse;
  padding: 4px;
}
</style>
<body>

<!-- //Is this used?? -->
<div id="error_message"></div>  

<!-- Show All Users -->
<h2>List of first 50 patrons sorted by "city"</h2>
<p>SQL COMMAND:<br><code>$sql = "SELECT * FROM patron ORDER BY city, lastname LIMIT 50";</code></p>

<p>Even though the select statment retrieved all of the data, we're only displaying certain columns.  Instead of doing this, we can actually change * to specify
the columns that we want.<br>
We can also get a specific city from the GET field of a Form and then just display that. However, in order to do that, we need to use "prepared statments" to prevent SQL injection.</p>

<hr style="background-color:gray;height:1px;">
<table>
	<tr>
		<th class="align-bottom">Full name</th>
		<th class="align-bottom">Address</th>
		<th class="align-bottom">City</th>
		<th class="align-bottom">Birthdate</th>
	</tr>

<?php
#go through each record
while($row = $result->fetch_assoc()) {
    $name = $row['lastname'].", ".$row['firstname'];
    $address = $row['address'];
    $city = $row['city'];
    $birthdate = $row['birthdate'];

	echo "<tr>";
    echo "<td>$name</td>";
    echo "<td>$address</td>";
    echo "<td>$city</td>";
    echo "<td>$birthdate</td>";
	echo "</tr>";
}
?>
</table>

<hr style="background-color:green;height:2px;">


</body>
</html>
