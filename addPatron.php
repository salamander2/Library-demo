<!DOCTYPE HTML>
<html>
	<head>
		<title>Add Patron</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="main.css"/>
	</head>
	<body class="is-preload">
					<div id="main">
							<article class="post featured">
								<header class="major">
									<hr />
									<h2>
										<a href="#" style="text-transform: none;">Add a Patron</a></h2>
								</header>
							</article>
					</div>
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
				$error_message = "";
				if (strlen($phone)>20){
					$error_message = "Try Using a valid phone number";
				}
				else if (strlen($email)>50){
					$error_message = "Your email is too long, try using another one";
				}
				else if (sizeof($partName) != 2){
					$error_message = "Try Using a first and last name sperated by a space";
				}
				else if(strlen($partName[0])>30){
					$error_message = "Your first name appers to be too long try shortining it up";
				}
				else if(strlen($partName[1])>10){
					$error_message = "Your last name appers to be too long try shortining it up";
				}else{
					$error_message = "";
				}
			}

			if (isset($_POST['submit']) and $error_message == ""){ ?>
				<article class="post featured">
				<div id="main">
					<h2>Hello <?=$partName[0]?> you have beed added to the database</h2>
				<ul>
					<li>
						Name: <?=$name?> 
					</li>
					<li>
						City: <?=$city?> 
					</li>
					<li>
						Province: <?=$prov?> 
					</li>
					<li>
						Address: <?=$address?> 
					</li>
					<li>
						Postal Code: <?=$postal?> 
					</li>
					<li>
						Birthdate: <?=$birthdate?>
					</li>
				<?php
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
					if($phone != Null){?>
						<li>	
						Phone <?=$phone?>		
						</li>
					<?php }
					if($email != Null){?>
						<li>
						email: <?=$email;?>		
						</li>
					<?php }
				}else{?>
					<li>
						Contact Info: Not specified
					</li>
			<?php }?>
				</ul>
				<h3> You will soon be redirected back to the main page</h3>
				</div>
				</article>
			<?php
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
		 }
		 else{ ?>
			<style>
				.error {
				  color:#000;
				  font-weight:bold;
				  padding:4px 0 4px 4px;
				  background:#F33;
				  text-align:center;
				}
				.green { color:green; }
			</style>
			
			<div id="main">
					<article class="post featured">
						<h3 class="error">
							<?=$error_message?>
						</h3>
					</article>
			</div>
			<footer id="footer" style="background-color: rgb(255, 255, 255)">
				<section >
					<form method="post" action="">
					<div class = "first">
						<div class="fields">
							<div class="field">
								<label for="name">First and Last Name</label>
								<input name="name" id="name" type="text" value = "<?=$name?>" maxlength = "61" required>
							</div>
							<div class="field">
								<label for="email">Contact info (phone or email seperated by a comma): </label>
								<input type ="name" name ="contact" id="email" value="<?=$contact?>"><sup>*Not required</sup>
							</div>
                            <div class="field">
								<label for="address">Address</label>
								<input type ="name" name ="address" id="address" value = "<?=$address?>" maxlength = "255" required>
							</div>
							<div class="field">
								<label for="message">Birthdate</label>
								<input type ="date" name ="birthdate" value = "<?=$birthdate?>" required>
							</div>
                            
						</div>
						<button type = "submit" name ="submit">SUBMIT</button>
					</div>
				</section>
				<section class="split contact">
					<section class="alt">
                        <div class="field">
                            <label for="email">Province</label>
							<input type ="name" name ="prov"  id="province" value = "<?=$prov?>" maxlength = "2" required>
                        </div>
					</section>
					<section>
                        <div class="field">
                            <label for="city">City</label>
							<input type ="name" name ="city" id = "city" value = "<?=$city?>"  maxlength = "100" required>
                        </div>
					</section>
					<section>
                        <div class="field">
                            <label for="postal">Postal Code</label>
							<input type ="postal" name ="postalCode" id = "postal" value = "<?=$postal?>" maxlength = "6" required>
                        </div>
					</section>
				</section>
			</footer>

		  <?php } ?>
		 
	</body>
</html>
