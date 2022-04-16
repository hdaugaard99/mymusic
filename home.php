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
	<?php include "database.php"?>
	
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="home.php">MyMusic Lists</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
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
	$result = mysqli_query($conn2, "SELECT albums.album_id, albums.album_title, artists.artist_name, albums.album_art FROM albums INNER JOIN artists ON albums.artist_id=artists.artist_id LIMIT 4");
	
	$result2 = mysqli_query($conn2, "SELECT * FROM artists LIMIT 4");
	
	$result3 = mysqli_query($conn2, "SELECT songs.song_id, songs.song_name, artists.artist_name FROM songs INNER JOIN artists ON songs.artist_id=artists.artist_id LIMIT 4");
	
	?>
	<h2>Albums</h2>
	<?php
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
	
	class Artist {
				public $id;
				public $name;
				
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
			}
	
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
		
			$newalbum[] = new Album();
			$newalbum[$i]->set_id($row['album_id']);
			$newalbum[$i]->set_title($row['album_title']);
			$newalbum[$i]->set_artist($row['artist_name'])
			?>
	<div class="card border-primary mb-3" style="max-width: 20rem;">
  <div class="card-header">Album</div>
  <div class="card-body">
	  
    <h4 class="card-title"><?php echo $newalbum[$i]->get_title(); ?></h4>
    <p class="card-text"><?php echo $newalbum[$i]->get_artist(); ?></p>
	 <button type="button" class="btn btn-outline-primary" onclick="window.location.href='album.php/<?php echo $newalbum[$i]->get_id(); ?>/'">View Album</button>
  </div>
</div>
			
				<?php
			$i++;
		}
	?>
<div class="card border-secondary mb-3" style="max-width: 20rem;">
 
  <div class="card-body">
    <h4 class="card-title">View All</h4>
    <p class="card-text">See a list of all albums in our database.</p>
	  <button type="button" class="btn btn-primary" onclick="window.location.href='albums.php'">View All Albums</button>
  </div>
</div>
		<?php
	?>
	<br><br>
	<h2>Artists</h2>
	<?php
	
		while ($row = mysqli_fetch_array($result2)) {
			$i = 0;
			$newartist[] = new Artist();
			$newartist[$i]->set_id($row['artist_id']);
			$newartist[$i]->set_name($row['artist_name']);
			?>
	
		<div class="card border-primary mb-3" style="max-width: 20rem;">
  <div class="card-header">Artist</div>
  <div class="card-body">
	  
    <h4 class="card-title"><?php echo $newartist[$i]->get_name(); ?></h4>
<button type="button" class="btn btn-outline-primary" onclick="window.location.href='artist.php/<?php echo $newartist[$i]->get_id(); ?>/'">View Artist</button>
  </div>
</div>
	
	<?php
			$i++;
		}
	?>
	<div class="card border-secondary mb-3" style="max-width: 20rem;">
 
  <div class="card-body">
    <h4 class="card-title">View All</h4>
    <p class="card-text">See a list of all artists in our database.</p>
	  <button type="button" class="btn btn-primary" onclick="window.location.href='artists.php'">View All Artists</button>
  </div>
</div>
	<?php
	?>
	<br><br>
	<h2>Songs</h2>
	<?php
		
		while ($row = mysqli_fetch_array($result3)) {
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
				$i++;
		}
	?>
	<div class="card border-secondary mb-3" style="max-width: 20rem;">
 
  <div class="card-body">
    <h4 class="card-title">View All</h4>
    <p class="card-text">See a list of all songs in our database.</p>
	  <button type="button" class="btn btn-primary" onclick="window.location.href='songs.php'">View All Songs</button>
  </div>
</div>
	<?php
	
	?>
	<div>

	</div>
</body>
</html>