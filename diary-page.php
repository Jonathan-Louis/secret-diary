<?php

	session_start();
	
	if(array_key_exists('id', $_COOKIE)){
		
		$_SESSION['id'] = $_COOKIE['id'];
		
	}

	if(array_key_exists('id', $_SESSION)){
		
		echo "<p>Logged in! <a href='secret-diary-login.php?logout=1'>Log out</a></p>";
		
	} else {
		
		header("Location: secret-diary-login.php");
		
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
		
		textarea{
			width:90%;
			height:1000px;
		}

		
		</style>
		
	</head>
	
	<body>
	
		<div class="container-fluid">
		
			<textarea id="diary" class="form-control"></textarea>
		
		</div>
	
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

		<script type="text/javascript">

			$("#diary").bind('input propertychange', function(){
				
				$.ajax({
					
					method: "POST",
					
					url: "updateDatabase.php",
					
					data: { content: $("#diary").val() }
					
				}).done(function( msg ) {
					
				});
				
			});
			
		</script>
		
	</body>



</html>