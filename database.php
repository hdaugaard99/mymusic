<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
	<?php
	$url='127.0.0.1';
	$username='root';
	$password='';
	$db='accounts';
	$charset = 'utf8';
	
	if(isset($_SESSION['username'])) {
	$conn5 = mysqli_connect($url, $username, $password, $_SESSION['username']);
	$_SESSION['conn5'] = $conn5;}
	
	$conn4 = mysqli_connect($url, $username, $password);
	$conn=mysqli_connect($url, $username, $password, $db);
	if(!$conn){
		die('Could not connect MySQL:' .mysql_error());
	}
	
	$db2 = 'music';
	$conn2=mysqli_connect($url, $username, $password, $db2);
	if(!$conn2){
		die('Could not connect MySQL:' .mysql_error());
	}
	
	$db3 = 'userlists';
	$conn3 = mysqli_connect($url, $username, $password, $db3);
	if(!$conn3){
		die('Could not connect MySQL:' .mysqli_error());
	}
	
		$dsn = "mysql:host=$url;dbname=$db;charset=$charset";
	$dsn2 = "mysql:host=$url;dbname=$db3;charset=$charset";
	$musicdsn = "mysql:host=$url;dbname=$db2;charset=$charset";
	$opt = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false
		];
	
	$pdo = new PDO($dsn, $username, $password, $opt);
	$pdo2 = new PDO($dsn2, $username, $password, $opt);
	$musicpdo = new PDO($musicdsn, $username, $password, $opt);
	?>
</body>
</html>