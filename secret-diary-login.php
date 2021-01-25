<?php

	session_start();
	
	if(array_key_exists('logout', $_GET)){
		
		unset($_SESSION);
		
		setcookie('id', "", time() - 60 * 60);
		
		$_COOKIE['id'] = "";
		
	} else if((array_key_exists('id', $_SESSION) && $_SESSION['id']) OR (array_key_exists('id', $_COOKIE) && $_COOKIE['id'])){
		
		header("Location: diary-page.php");
		
	}

	include("connection.php");
	
	$error = "";
	
	$success = "";
	
	if(array_key_exists('emailAddress', $_POST) OR array_key_exists('password', $_POST)){
	
		if(!$_POST['emailAddress']){
			
			$error .= "An email address is required.<br>";
			
		}

		if(!$_POST['password']){
			
			$error .= "A password is required.<br>";
			
		}
		
		if($error != ""){
			
			$error = "There were error(s) with your form: <br>".$error;
			
		} else{
			
			if($_POST['signUp'] == '1'){
			
				$query = "SELECT `id` FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['emailAddress'])."'";
				
				$result = mysqli_query($link, $query);
				
				if(mysqli_num_rows($result) > 0 ){
					
					$error = "That email address is already taken";
					
				} else{
				
					$query = "INSERT INTO `users` (`email`, `password`) VALUES('".mysqli_real_escape_string($link, $_POST['emailAddress'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
					
					if(mysqli_query($link, $query)){
						
						$query = "UPDATE `users` SET `password` = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
						
						mysqli_query($link, $query);
						
						$_SESSION['id'] = mysqli_insert_id($link);
						
						if($_POST['stayLoggedIn'] == 1){
							
							setcookie('id', mysqli_insert_id($link), time() + (60 *60 * 24 *7));
							
						}
						
						header("Location: diary-page.php");
						
						$success = "Registered!";
						
					} else{
						
						echo "<p>an error occured</p>";
						
					}
					
				}
				
			} else{
					
				$query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['emailAddress'])."'";
				
				$result = mysqli_query($link, $query);
				
				$row = mysqli_fetch_array($result);
				
				if(array_key_exists('id', $row)){
					
					$hashedPassword = md5(md5($row['id']).$_POST['password']);
					
						if($hashedPassword == $row['password']){
					
							$_SESSION['id'] = mysqli_insert_id($link);
							
							if($_POST['stayLoggedIn'] == 1){
								
								setcookie('id', $row['id'], time() + (60 *60 * 24 *7));
								
							}
							
							header("Location: diary-page.php");
							
						} else{
							
							$error = "Incorrect password, please try again";
							
						}
					
				} else {
					
					$error = "Email not found, please Sign Up!";
				}	
				
			}
		}
			
	}



?>






<!doctype html>
<html lang="en">

	<head>
	
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<title>Secret Diary</title>
		
		<style type="text/css">
		
			html { 
				background: url(background.jpeg) no-repeat center center fixed; 
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}
			
			body{
				background:none;
			}
		
			#para1{
				font-weight:bold;
				font-size:16px;
			}
			
			p{
				color:white;
			}
			
			h1{
				color:white;
			}
			
			.toogleParagraph{
				color:darkgrey;
				top-margin:20px;
			}
			
			#emailHelp{
				color:#D3D3D3;
			}
			
			.logged-in-label{
				color:white;
			}
		
			.container{
				text-align:center;
				margin-top:150px;
				width:500px;
			}
			
			#loginForm{
				display:none;
			}
			
		
		
		</style>
		
	</head>
	
	<body>
	
		<div class="container">
		
			<h1>Secret Diary</h1>
			
			<p id="para1">Store your thoughts permanently and securely</p>
			
			<p>Interested? Sign Up Now!</p>
			
			<div id="error">
				<?php 
				
					if($error){
						
						echo "<div class='alert alert-danger' role='alert'>".$error."</div>";
						
					}
				
				?>
			</div>


			<form method="post" id="signUpForm">
			
				<div class="form-group">
				
					<input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="YourEmail@email.com" aria-describedby="emailHelp">
					<small id="emailHelp" class="form-text">We'll never share your email with anyone else.</small>
					
				</div>
				
				<div class="form-group">

					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					
				</div>
					
				<div class="form-group form-check">
				
					<input type="checkbox" class="form-check-input" id="stayLoggedIn" name="stayLoggedIn">
					<label class="form-check-label logged-in-label" for="stayLoggedIn">Stay logged in?</label>
					
				</div>
				
				<input type="hidden" name="signUp" value="1">
				
				<button type="submit" class="btn btn-primary">Sign Up!</button>
				
				<p class="toogleParagraph"><a class="toggleForms" id="showLoginForm">Log in</a></p>
				
			</form>
					
	

			<form method="post" id="loginForm">
			
				<div class="form-group">
				
					<input type="email" class="form-control" id="emailAddress" name="emailAddress"  placeholder="YourEmail@email.com" aria-describedby="emailHelp">
					
				</div>
				
				<div class="form-group">

					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					
				</div>
					
				<div class="form-group form-check">
				
					<input type="checkbox" class="form-check-input" id="stayLoggedIn" name="stayLoggedIn">
					<label class="form-check-label logged-in-label" for="stayLoggedIn">Stay logged in?</label>
					
				</div>
				
				<input type="hidden" name="signUp" value="0">
				
				<button type="submit" class="btn btn-primary">Log In!</button>
				
				<p class="toogleParagraph"><a class="toggleForms" id="showSignUpForm">Sign Up</a></p>
				
			</form>
						

			
			
			
		</div>
		
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

		<script type="text/javascript">
		
			$(".toggleForms").click(function() {
				
				$("#signUpForm").toggle();
				
				$("#loginForm").toggle();
			
			});
			
			
		
		</script>
		
	</body>



</html>