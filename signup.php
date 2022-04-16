<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
	<?php include 'database.php'?>
	<?php
	if(isset($_POST["signup"])) {
		$name = $_POST['name'];
		$email = $_POST['username'];
		$password = $_POST['password'];
		$result = mysqli_query($conn, 'SELECT * FROM users');
			
				$checkemail = mysqli_query($conn, 'SELECT * FROM users WHERE email = "'.$email.'"');
				if (mysqli_num_rows($checkemail) > 0) {
					echo "<script>alert('The email you have selected is already associated with an account.')</script>";
				} else {
					$sqlsignup = "INSERT INTO users (name, email, password) 
					VALUES('$name', '$email', '$password')";
					mysqli_query($conn, $sqlsignup);
					
				
			
					$i=0;
					$stmt = $pdo->query('SELECT * FROM users WHERE email = "'.$_POST['username'].'"');
					while ($row = $stmt->fetch()) {
						$_SESSION['username'] = $row["email"];
						if ($row['email'] = $_SESSION['username']) {
							break;
					}
						else {
							$i++;
					}
						
				
			
				}
		
					$username = $_SESSION['username'];
					// Create database
					$sql = "CREATE DATABASE $username";
					if (mysqli_query($conn4, $sql)) {
						echo "Database created successfully";
						
					} else {
						echo "Error creating database: " . $conn->error;
					}
					

				}
			}
		
	?>
	<h1>MyMusic Lists</h1><br>
	<h3>Sign Up</h3>
	<form method="post">
		<label>Name: </label>
		<input type="text" name="name" placeholder="name" required>
		
		<label>Username: </label>
		<input type="text" name="username" placeholder="Username" required>
		
		<label>Password: </label>
		<input type="password" name="password" placeholder="password">
		
		<button type="submit" name="signup">Sign Up</button>
	
	
	</form>
	
	<p>Already have an account? <a href="signin.php">Sign In</a></p>
</body>
</html>