<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Adding a Patron</title>
<!-- Link to local bootstrap file. -->
 <link rel="stylesheet" href="resources/bootstrap-5.2.3-dist/css/bootstrap.min.css" >
<!-- make sure that the webpage works on cell phones too -->
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
<?php
    require_once('common.php');
	$db = connectToDB();

    $email = $phone = $name = $city = $prov = $address = $postal = $contact = $birthdate = "";
    if (isset($_POST['submit'])){
        $name =  clean_input($_POST['name']);
        $city=  clean_input($_POST['city']);
        $prov =  clean_input($_POST['prov']);
        $address=  clean_input($_POST['address']);
        $postal=  clean_input($_POST['postalCode']);
        $contact=  clean_input($_POST['contact']);
        $birthdate=  clean_input($_POST['birthdate']);
        $name = ucwords($name);
        $partName= explode(" ", $name);
        $prov = strtoupper($prov);
        $address = ucwords($address);
        $postal = strtoupper($postal);
        $contactInfo = explode(",",$contact);
        foreach ($contactInfo as $info){
			$contact_array = str_split($info);
			foreach ($contact_array as $char){
				if ($char == "@"){
					$isEmail = True;
					break;
				}else{
					$isEmail =False ;
				}
			}
		}
		if($isEmail){
			$email = $info;
		}else{
			$phone = $info;
		}

        if (strlen($phone)>20){
			$error_message = "Try Using a valid phone number";
			echo $error_message;
        }
        if (strlen($email)>50){
			$error_message = "Your email is too long, try using another one";
			echo $error_message;
        }
        if (sizeof($partName) != 2){
            $error_message = "Try Using a first and last name sperated by a space";
            echo $error_message;
        }
        if(strlen($partName[0])>30){
            $error_message = "Your first name appers to be too long try shortining it up";
            echo $error_message;
        }
        if(strlen($partName[1])>10){
            $error_message = "Your last name appers to be too long try shortining it up";
            echo $error_message;
        }else{
            $error_message = '';
        }
	}

	if (isset($_POST['submit']) and empty($error_message)){
		echo "<h1>Hello ".$partName[0]." you have beed added to the database</h1>";
        echo "Name:".$name."<br>";
        echo "City:".$city."<br>";
        echo "Province:".$prov."<br>";
        echo "Address:".$address."<br>";
        echo "Postal Code:".$postal."<br>";
        echo "Birthdate:".$birthdate."<br>";
		foreach ($contactInfo as $info){
			$contact_array = str_split($info);
			foreach ($contact_array as $char){
				if ($char == "@"){
					$isEmail = True;
					break;
				}else{
					$isEmail =False ;
				}
			}
				if($isEmail){$email = $info;}else{$phone = $info;}
		}
		if ($contact != ""){
			if($phone != Null){
				echo "phone ".$phone;		
				echo "<br>";
			}
			if($email != Null){
				echo "email ".$email;		
			}
		}else{echo "Contact Info: Not specified<br>";}

        $sql = "INSERT INTO patron (firstname,lastname, address,city, prov, postalCode,phone,email, birthdate) VALUES (?,?,?, ?, ?, ?, NULLIF(?,''), NULLIF(?,''), ?);";
        if ($stmt = $db->prepare($sql)) {
			$stmt->bind_param("sssssssss",$partName[0], $partName[1], $address, $city, $prov, $postal,$phone,$email,$birthdate);
			$stmt->execute();
			$stmt->close();
        } else {
			$message = 'Invalid query: ' . mysqli_error($db) . "\n";
			$message .= 'SQL: ' . $sql;
			die($message);
		}
         header( "refresh:5;url=https://webdev.iquark.ca/~mhammoud/Library-demo/listPatron.php" );
         echo "<h3> You will soon be redirected back to the main page</h3>";
 }
 else{
         echo "<form method = \"post\" action=\"\">";
                 echo "<p>";
                 echo "First and Last Name <input name=\"name\" type=\"text\" value = \"$name\" maxlength = \"61\"required>";
                 echo "<br> Street address: <input type =\"name\" name =\"address\" value = \"$address\" maxlength = \"255\" required>";
                 echo "<br> City: <input type =\"name\" name =\"city\"value = \"$city\"  maxlength = \"100\" required>";
                 echo "<br> Provence: <input type =\"name\" name =\"prov\"  value = \"$prov\" maxlength = \"2\"required>";
                 echo "<br> Postal Code: <input type =\"postal\" name =\"postalCode\" value = \"$postal\" maxlength = \"6\"required>";
                 echo "<br> Contact info (phone or email seperated by a comma): <input type =\"name\" name =\"contact\" value - \"$contact\"><sup>*Not required</sup>";
                 echo "<br> Birthdate: <input type =\"date\" name =\"birthdate\"value = \"$birthdate\" required>";
                 echo "</p>";
                 echo '<button type = "submit" name ="submit">SUBMIT</button>';
         echo"</form>";
   }
 ?>
</body>
</html>
