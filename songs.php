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
      <li class="nav-item active">
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
	
		<h2>Songs</h2><br>
		<form action="searchsongs.php" method="GET">
			<input type="text" name="query" />
			<input type="submit" value="Search" />
		</form><br>
	<?php
		$result = mysqli_query($conn2, "SELECT songs.song_id, songs.song_name, artists.artist_name FROM songs INNER JOIN artists ON songs.artist_id=artists.artist_id");
	
		class Song {
				public $id;
				public $name;
				public $artist;
				
				function set_id($id) {
					$this->id = $id;
				}
				function get_id() {
					return $this->id;
				}
				function set_name($name) {
					$this->name = $name;
				}
				function get_name() {
					return $this->name;
				}
				function set_artist($artist) {
					$this->artist = $artist;
				}
				function get_artist() {
					return $this->artist;
				}
				
			}
	
		while ($row = mysqli_fetch_array($result)) {
			$i = 0;
			$newsong[] = new Song();
			$newsong[$i]->set_id($row['song_id']);
			$newsong[$i]->set_name($row['song_name']);
			$newsong[$i]->set_artist($row['artist_name']);
			?>
			
					<div class="card border-primary mb-3" style="max-width: 20rem;">
  <div class="card-header">Song</div>
  <div class="card-body">
	  
    <h4 class="card-title"><?php echo $newsong[$i]->get_name(); ?></h4>
    <p class="card-text"><?php echo $newsong[$i]->get_artist(); ?></p>
	  <button type="button" class="btn btn-outline-primary" onclick="window.location.href='song.php/<?php echo $newsong[$i]->get_id(); ?>/'">View Song</button>
  </div>
</div>
	
	<?php
		}
		if (isset($_POST['submit'])) {
		
		$songTitle = $_POST['songTitle'];
		$artistName = $_POST['artistName'];
		$albumTitle = $_POST['albumTitle'];
		$year = $_POST['year'];
		
		
		mysqli_query($conn2, "INSERT INTO artists (artist_name) SELECT '$artistName' WHERE NOT EXISTS ( SELECT * FROM artists WHERE artist_name = '$artistName' )");
			
		$selectArtist = mysqli_query($conn2, "SELECT artist_id, artist_name FROM artists");
			
		while ($row = mysqli_fetch_array($selectArtist)) {
			if ($row['artist_name'] == $artistName) {
				$artistId = $row['artist_id'];
			}
		}
			
		mysqli_query($conn2, "INSERT INTO albums (album_title, artist_id, year) SELECT '$albumTitle', '$artistId', '$year' WHERE NOT EXISTS ( SELECT * FROM albums WHERE album_title = '$albumTitle')");
			
		$selectAlbum = mysqli_query($conn2, "SELECT album_id, album_title FROM albums");
			
		while ($row = mysqli_fetch_array($selectAlbum)) {
			if ($row['album_title'] == $albumTitle) {
				$albumId = $row['album_id'];
			}
		}

		mysqli_query($conn2, "INSERT INTO songs (song_name, album_id, artist_id, year) VALUES('$songTitle', '$albumId', '$artistId', '$year')");
		
	
	}
	
	?>
	
		<h3>Add Song</h3><br>
	
	<form method="post" enctype="multipart/form-data">
		<label>Song Title:</label>
		<input type="text" name="songTitle">
		
		<label>Artist:</label>
		<input type="text" name="artistName">
		
		<label>Album Title:</label>
		<input type="text" name="albumTitle">
		
		<label>Year:</label>
		<input type="text" name="year">
	
		
		<button type="submit" name="submit">Add Song</button>
	</form>
</body>
</html>