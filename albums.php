<?php

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
	<?php include "searchalbums.php" ?>
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
	
	<h2>Albums</h2><br>
	<form action="searchalbums.php" method="GET">
		<input type="text" name="query" />
		<input type="submit" value="Search" />
	</form><br>
	<?php
		$result = mysqli_query($conn2, "SELECT albums.album_id, albums.album_title, artists.artist_name, albums.album_art FROM albums INNER JOIN artists ON albums.artist_id=artists.artist_id");
	
	class Album {
				public $id;
				public $title;
				
				function set_id($id) {
					$this->id = $id;
				}
				function get_id() {
					return $this->id;
				}
				function set_title($title) {
					$this->title = $title;
				}
				function get_title() {
					return $this->title;
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
			
			$newalbum[] = new Album();
			$newalbum[$i]->set_id($row['album_id']);
			$newalbum[$i]->set_title($row['album_title']);
			$newalbum[$i]->set_artist($row['artist_name']);
			?>
	 	<div class="card border-primary mb-3" style="max-width: 20rem;">
  <div class="card-header">Album</div>
  <div class="card-body">
	  
    <h4 class="card-title"><?php echo $newalbum[$i]->get_title(); ?></h4>
    <p class="card-text"><?php echo $newalbum[$i]->get_artist(); ?></p>
	 <button type="button" class="btn btn-outline-primary" onclick="window.location.href='album.php/<?php echo $newalbum[$i]->get_id(); ?>/'">View Album</button>
  </div>
</div>
</div>
			
				<?php
		}
	
	if (isset($_POST['submit'])) {
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES['albumArt']['name']);
		
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$error=true;
		}
		
		if(move_uploaded_file($_FILES['albumArt']['tmp_name'], $target_file)) {
			echo "The file ". basename($_FILES['albumArt']['name']). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
		
		
		
		if ($_FILES['albumArt']['name'] > 500000) {
			echo "Sorry, your file is too large.";
			$error = true;
		}
		
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
		
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$error=true;
		}
		
		$albumTitle = $_POST['albumTitle'];
		$artistName = $_POST['artistName'];
		$year = $_POST['year'];
		$albumArt = $_FILES['albumArt']['name'];
		
		mysqli_query($conn2, "INSERT INTO artists (artist_name) SELECT '$artistName' WHERE NOT EXISTS ( SELECT * FROM artists WHERE artist_name = '$artistName' )");
		
		$selectArtist = mysqli_query($conn2, "SELECT artist_id, artist_name FROM artists");
		
		while ($row = mysqli_fetch_array($selectArtist)) {
			if ($row['artist_name'] == $artistName) {
				$artistId = $row['artist_id'];
			}
		}
		
		mysqli_query($conn2, "INSERT INTO albums (album_title, artist_id, year, album_art) VALUES('$albumTitle', '$artistId', '$year', '$albumArt')");
		
		mysqli_query($conn2, "UPDATE albums SET albums.artist_id WHERE album_title = '$albumTitle' FROM artists WHERE artist_name = '$artistName'");
		
	
	}
		
		
		
	
	
		
?>
	<br>
	<h3>Add Album</h3><br>
	
	<form method="post" enctype="multipart/form-data">
		<label>Album Title:</label>
		<input id="albumTitle" type="text" name="albumTitle">
		
		<label>Artist:</label>
		<input id="artist" type="text" name="artistName">
		
		<label>Year:</label>
		<input id="year" type="text" name="year">
		
		<label>Album Artwork:</label>
		Select image to upload:
		<input id="albumArt" type="file" name="albumArt">
	
		
		<button type="submit" name="submit">Add Album</button>
	</form>
	

</body>
</html>