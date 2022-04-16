<?php
session_start();
if(!isset($_SESSION['user_id'])) {
	header("Location: signup.php");
}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
	<link rel="stylesheet" type="text/css" href="http://192.168.64.2/FinalProject/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="http://192.168.64.2/FinalProject/styles.css">
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
      <li class="nav-item active">
        <a class="nav-link" href="http://192.168.64.2/FinalProject/albums.php">Albums</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://192.168.64.2/FinalProject/artists.php">Artists</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://192.168.64.2/FinalProject/songs.php">Songs</a>
      </li>
		 <li class="nav-item">
        <a class="nav-link" href="http://192.168.64.2/FinalProject/yourLists.php">Your Lists</a>
      </li>
    </ul>
	  <form class="form-inline my-2 my-lg-0">
	  		<button type="button" class="btn btn-secondary"><a href="http://192.168.64.2/FinalProject/signout.php">Sign Out</a></button>
	  </form>
  </div>
</nav><br>
	
	<?php
	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	
	$result = mysqli_query($conn2, "SELECT albums.album_id, albums.artist_id, albums.album_title, albums.year, albums.album_art, artists.artist_name FROM albums INNER JOIN artists ON albums.artist_id=artists.artist_id");
	
	while ($row = mysqli_fetch_array($result)) {
		$i = $row['album_id'];
		if (strpos($url,"album.php/$i/") == true) {
			$albumId = $row['album_id'];
			$artistId = $row['artist_id'];
			?>
			<h1><?php echo $row['album_title'] ?></h1>
			<img src="http://192.168.64.2/FinalProject/uploads/<?php echo $row['album_art'] ?>">
			
			<h2><?php echo $row['artist_name'] ?></h2>
			<p><?php echo $row['year'] ?></p>
	
	
	<?php
			$albumTitle = $row['album_title'];
			$artistName = $row['artist_name'];
			$year = $row['year'];
			$albumArt = $row['album_art'];
			
			
		}
	}
	
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
	
	
	
	$databaseName = $_SESSION['username'];
	
	$stmt3 = $pdo2->query("SELECT list_name FROM list_ids WHERE user_id = '".$_SESSION['user_id']."'");
		while ($row = $stmt3->fetch()) {
			$lists[] = $row['list_name'];
		}
	
	if (isset($_POST['addAlbum'])) {
		$selectList = $_POST['selectList'];
		mysqli_query($conn5, "INSERT INTO $selectList (album_id, artist_id) VALUES('$albumId', '$artistId')");
		echo $albumId;
	}

	
	?>

	
	<h2>Add to List</h2>
	<form method="post">
		<select name="selectList">
		<?php
		foreach ($lists as $list) {
			?>
		
			<option value="<?php echo $list ?>"><?php echo $list ?></option>
		
		<?php
			$x++;
		} ?>
		</select>
		
		<button type="submit" name="addAlbum">Add Album to List</button>
	</form>
	
	
	
</body>
</html>