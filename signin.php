<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
	<?php include "database.php" ?>
	
	<?php
	if (isset($_POST['signin'])) {
		$email = $_POST['username'];
		$password = $_POST['password'];
		$result = mysqli_query($conn, 'SELECT id FROM users WHERE email = "'.$_POST['username'].'"');
		
		$stmt = $pdo->query('SELECT * FROM users WHERE email = "'.$email.'"');
		while ($row = $stmt->fetch()) {
			if (isset($_POST['signin'])){
				$_SESSION['id'][] = $row["id"];
			}
		}
		
		$checkemailpassword = mysqli_query($conn, 'SELECT * FROM users WHERE email = "'.$email.'" AND password = "'.$password.'"');
		
		if(mysqli_num_rows($checkemailpassword) > 0) {
			$_SESSION['logged_in'] = true;
			$result = mysqli_query("SELECT id FROM users WHERE email = '".$email."'");
			$_SESSION['user_id'] = $result;
			header('Location: yourLists.php');
			
		} else {
			print_r('The username or password are incorrect.');
		}
	}
	
	?>
	<h1>MyMusic Lists</h1><br>
	<h3>Sign In</h3>
	<form method="post">
		<label>Username: </label>
		<input type="text" name="username" placeholder="username">
		
		<label>Password: </label>
		<input type="password" name="password" placeholder="Password">
		
		<button type="submit" name="signin">Sign In</button>
	
	</form>
</body>
</html>