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
      <li class="nav-item active">
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
	
		<h2>Artists</h2><br>
		<form action="searchartists.php" method="GET">
			<input type="text" name="query" />
			<input type="submit" value="Search" />
		</form><br>
	<?php
		$result = mysqli_query($conn2, "SELECT * FROM artists");
	
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
	
		while ($row = mysqli_fetch_array($result)) {
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
		}
	
	if (isset($_POST['submit'])) {
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES['artistPhoto']['name']);
		
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$error=true;
		}
		
		if(move_uploaded_file($_FILES['artistPhoto']['tmp_name'], $target_file)) {
			echo "The file ". basename($_FILES['artistPhoto']['name']). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
		
		
		
		if ($_FILES['artistPhoto']['name'] > 500000) {
			echo "Sorry, your file is too large.";
			$error = true;
		}
		
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
		
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$error=true;
		}
		
		$artistName = $_POST['artistName'];
		$artistPhoto = $_FILES['artistPhoto']['name'];
		
		mysqli_query($conn2, "INSERT INTO artists (artist_name, artist_photo) SELECT '$artistName', '$artistPhoto' WHERE NOT EXISTS ( SELECT * FROM artists WHERE artist_name = '$artistName' )");
		
	
	}
	?>
	
	<h3>Add Artist</h3><br>
	
	<form method="post" enctype="multipart/form-data">
		<label>Artist Name:</label>
		<input type="text" name="artistName">
		
		<label>Artist Photo:</label>
		Select image to upload:
		<input type="file" name="artistPhoto">
	
		
		<button type="submit" name="submit">Add Artist</button>
	</form>
</body>
</html>