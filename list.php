<?php
session_start();
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
	$user_name = $_SESSION['username'];
	$dsn4 = "mysql:host=$url;dbname=$user_name;charset=$charset";
	
	$dsn3 = "mysql:host=$url;dbname=$db3;charset=$charset";
	$pdo3 = new PDO($dsn3, $username, $password, $opt);
	$pdo4 = new PDO($dsn4, $username, $password, $opt);
	
	$result = mysqli_query($conn2, "SELECT albums.album_id, albums.album_title, artists.artist_name, albums.album_art FROM albums INNER JOIN artists ON albums.artist_id=artists.artist_id");
	
	$result2 = mysqli_query($conn2, "SELECT * FROM artists");
	
	$result3 = mysqli_query($conn2, "SELECT songs.song_id, songs.song_name, artists.artist_name FROM songs INNER JOIN artists ON songs.artist_id=artists.artist_id");
	
	$result4 = mysqli_query($conn3, "SELECT * FROM list_ids");
	
	
		
	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	
	$stmt3 = $pdo3->query("SELECT list_name FROM list_ids WHERE user_id = '".$_SESSION['user_id']."'");
		while ($row = $stmt3->fetch()) {
			$lists[] = $row['list_name'];
		}

	
	
	
	foreach($lists as $list) {
		if (strpos($url, "list.php/$list") == true) {
			echo "<h1>".$list."</h1><br>";
			$list_name = $list;
		}
	}
	
	$select_album_ids = $pdo4->query("SELECT list_id, album_id FROM $list_name WHERE song_id IS NULL AND artist_id IS NOT NULL AND album_id IS NOT NULL");
	
	$select_song_ids = $pdo4->query("SELECT list_id, song_id FROM $list_name WHERE album_id IS NOT NULL AND artist_id IS NOT NULL AND song_id IS NOT NULL");
		
	$select_artist_ids = $pdo4->query("SELECT list_id, artist_id FROM $list_name WHERE album_id IS NULL AND song_id IS NULL");
	
	$album_ids = array();
	while ($row = $select_album_ids->fetch()) {
		$album_ids[] = (string)$row['album_id'];
		$album_list_ids[] = $row['list_id'];
		
		
	}
	
	$song_ids = array();
	while ($row = $select_song_ids->fetch()) {
		$song_ids[] = (string)$row['song_id'];
		$song_list_ids[] = $row['list_id'];
	}
	
	$artist_ids = array();
	while ($row = $select_artist_ids->fetch()) {
		$artist_ids[] = (string)$row['artist_id'];
		$artist_list_ids[] = $row['list_id'];
	}
	
		if(isset($_POST['deleteentry'])){
			$checkbox = $_POST['entry'];
			for($i=0;$i<count($checkbox);$i++){
				$del_date = $checkbox[$i]; 
				mysqli_query($conn5,"DELETE FROM $list_name WHERE list_id='".$del_date."'");
				$messagedeleteevent = "Event deleted successfully!";
}
}
	
	echo "<form method='post'><ul>";
	
	if ($album_ids != null) {
	foreach ($album_ids as $album_id) {
		$album = $musicpdo->query("SELECT albums.album_id, albums.album_title, artists.artist_name FROM albums INNER JOIN artists on albums.artist_id = artists.artist_id WHERE album_id = '$album_id'");
		while ($row = $album->fetch()) {
			$album_title = $row['album_title'];
			$artist_name = $row['artist_name'];
			
			$i = 0;
			foreach ($album_list_ids as $list_id) {
			if ($album_ids[$i] == (string)$row['album_id']) {
				$listId = $list_id;
			} else {
				$i++;
			}
		}
			
			?>
		<div class="card border-primary mb-3" style="max-width: 20rem;">
  <div class="card-header">Album</div>
  <div class="card-body">
	  <input type='checkbox' name='entry[]' value='<?php echo $listId ?>'>
    <h4 class="card-title"><?php echo $row['album_title'] ?></h4>
    <p class="card-text"><?php echo $row['artist_name'] ?></p>
	  <p><?php echo $listId ?></p>
	 <button type="button" class="btn btn-outline-primary" onclick="window.location.href='album.php/<?php echo $i?>/'">View Album</button>
  </div>
</div>
	<?php
		}
		
	}
	}
	
	if ($artist_ids != null) {
	foreach ($artist_ids as $artist_id) {
		$artist = $musicpdo->query("SELECT * FROM artists WHERE artist_id = '$artist_id'");
		
		while($row = $artist->fetch()) {
			$artist_name = $row['artist_name'];
			$i = 0;
			foreach ($artist_list_ids as $list_id) {
			if ($artist_ids[$i] == (string)$row['artist_id']) {
				$listId = $list_id;
			} else {
				$i++;
			}
			
			}
			
			?>
		<div class="card border-primary mb-3" style="max-width: 20rem;">
  <div class="card-header">Artist</div>
  <div class="card-body">
	  <input type='checkbox' name='entry[]' value='<?php echo $listId ?>'>
    <h4 class="card-title"><?php echo $row['artist_name'] ?></h4>
<button type="button" class="btn btn-outline-primary" onclick="window.location.href='artist.php/<?php echo $i?>/'">View Artist</button>
  </div>
</div>
	<?php
		}
		
	}
	}

	

	
	foreach ($song_ids as $song_id) {
		$song = $musicpdo->query("SELECT songs.song_id, songs.song_name, songs.artist_id, albums.album_title, artists.artist_name FROM songs INNER JOIN albums ON songs.album_id = albums.album_id INNER JOIN artists ON songs.artist_id = artists.artist_id WHERE song_id = '$song_id'");
		

		
		while($row = $song->fetch()) {
			$song_name = $row['song_name'];
			$artist_name = $row['artist_name'];
			$album_title = $row['album_title'];
			$song_ids[] = $row['song_id'];
			
			$i = 0;
			foreach ($song_list_ids as $list_id) {
			if ($song_ids[$i] == (string)$row['song_id']) {
				$listId = $list_id;
			} else {
				$i++;
			}
		}
				
			?>
	<div class="card border-primary mb-3" style="max-width: 20rem;">
  <div class="card-header">Song</div>
  <div class="card-body">
	  <input type='checkbox' name='entry[]' value='<?php echo $listId ?>'>
    <h4 class="card-title"><?php echo $row['song_name'] ?></h4>
    <p class="card-text"><?php echo $row['artist_name'] ?></p>
	  <button type="button" class="btn btn-outline-primary" onclick="window.location.href='song.php/<?php echo $i?>/'">View Song</button>
  </div>
</div>
			<?php
		
		}
		
	}
	?>
	<br>
	<button type='submit' name='deleteentry'>Delete Items</button>
	<?php
	echo "</ul></form>";

	
	?>
</body>
</html>