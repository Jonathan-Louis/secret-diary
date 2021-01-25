<?php

	$link = mysqli_connect("shareddb-l.hosting.stackcp.net", "usersDatabase-383304ba", "happy1!Jon", "usersDatabase-383304ba");
	
	if(mysqli_connect_error() != null){
		
		die("Error connecting to database");
		
	}
	
	
	if(array_key_exists('emailAddress', $_POST) OR array_key_exists('password', $_POST)){
		
		if($_POST['emailAddress'] == ''){
			echo "<p>An email is required</p>";
		}else if($_POST['password'] == ""){
			echo "<p>A password is required</p>";
		} else {
			$query = "SELECT `id` FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['emailAddress'])."'";
			
			$result = mysqli_query($link, $query);
			
			if(mysqli_num_rows($result) > 0 ){
				echo "<p>email address already taken</p>";
			} else{
				$query = "INSERT INTO `users` (`email`, `password`) VALUES('".mysqli_real_escape_string($link, $_POST['emailAddress'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
				if(mysqli_query($link, $query)){
					echo "<p>registered</p>";
				} else{
					echo "<p>an error occured</p>";
				}
			}
		}
		
	}
	


	
	
	//$query = "INSERT INTO `users` (`email`, `password`) VALUES('test@email.com', 'kljsdafE23')";
	
	//$query = "UPDATE `users` SET `email` = 'test1@email.com' WHERE id = 2 LIMIT 1";
	
	//mysqli_query($link, $query);
	
	//$query = "SELECT * FROM `users`";
	
	/*
	if($result = mysqli_query($link, $query)){
		
		$row = mysqli_fetch_array($result);
		
		echo "Email: ".$row['email']." <br>Password: ".$row['password'];
		
	} 
	*/
	

	
	
	

?>


<html>


	<form method="post">
	
		<input type="email" id="emailAddress" name="emailAddress" placeholder="email@email.com">
		

		<input type="password" id="password" name="password" placeholder="password">
		
		<input type="submit" value="Submit">
	
	</form>




</html>