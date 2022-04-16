// JavaScript Document

function addAlbum() {
	var valid;
	valid = validateContact();
	
	if(valid) {
		jQuery.ajax({
			url: "albums.php",
			
			data: 'albumTitle'+$("#albumTitle").val()+'artist='+$("#artist").val()+'year='+$("#year").val()+'albumArt='+$("#albumArt").val(),
			
			type: "POST",
			success:function(data){
				window.alert("Album added successfully!");
			},
			
			error: function () {}
		});
	}
}