<?php
session_start();
if(!isset($_SESSION['logged_in'])) {
	header("Location: signup.php");
}

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
	
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="home.php">MyMusic Lists</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="http://192.168.64.2/FinalProject/home.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://192.168.64.2/FinalProject/albums.php">Albums</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://192.168.64.2/FinalProject/artists.php">Artists</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://192.168.64.2/FinalProject/songs.php">Songs</a>
      </li>
		 <li class="nav-item active">
        <a class="nav-link" href="http://192.168.64.2/FinalProject/yourLists.php">Your Lists</a>
      </li>
    </ul>
	  <form class="form-inline my-2 my-lg-0">
	  		<button type="button" class="btn btn-secondary"><a href="http://192.168.64.2/FinalProject/signout.php">Sign Out</a></button>
	  </form>
  </div>
</nav>
	
	
	<?php
	$i = 0;
		
	if ($_SESSION['user_id'] = $_SESSION['id'][$i]) {
				
			}
			else {
				$i++;
			}
	
	$stmt2 = $pdo->query("SELECT email FROM users WHERE id = '".$_SESSION['user_id']."'");
	while ($row = $stmt2->fetch()) {
		$_SESSION['username'] = $row['email'];
		if ($row['email'] = $_SESSION['username']) {
			break;
		} else {
			$i++;
		}
		
	}
	
	
	$conn5 = mysqli_connect($url, $username, $password, $_SESSION['username']);
	$_SESSION['conn5'] = $conn5;
	
	$databaseName = $_SESSION['username'];
	
	
	if(isset($_POST['createlist'])) {
		
		$result = mysqli_query($conn5, "CREATE TABLE ".$_POST['listname']."(list_id int NOT NULL AUTO_INCREMENT, album_id int, artist_id int, song_id int, PRIMARY KEY (list_id))");
		
		$last_id = mysqli_insert_id($conn3);
		
		mysqli_query($conn3, "INSERT INTO list_ids (user_id, list_name) VALUES('".$_SESSION['id'][$i]."', '".$_POST['listname']."')");
		
	}
	
	
	
	?>

	<h1>Your Lists</h1>
	
	<ul class="list-group">
		
		<?php
		$stmt3 = $pdo2->query("SELECT list_name FROM list_ids WHERE user_id = '".$_SESSION['user_id']."'");
		while ($row = $stmt3->fetch()) {
			$lists[] = $row['list_name'];
		}
		?>
		
			<?php
			$x = 0;
			$lists = array();
			while ($x < count($lists)) {
				
				
				
				?>
				
  <li class="list-group-item d-flex justify-content-between align-items-center">
	  <a href='list.php/<?php echo $lists[$x] ?>'><?php echo $lists[$x] ?></a>
  </li>
		<?php
					$x++;
			}
		
		
		?>
	</ul>
	<br>
	<h2>New List</h2><br>
	<form method="post">
		<label>List Name</label>
		<input type="text" name="listname">
		
		<button type="submit" name="createlist">Create List</button>
	</form>
</body>
</html>