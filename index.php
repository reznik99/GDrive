<?php
/* Check if user logged in is valid */
require 'utils/validate_user.php';

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>GoriniDrive</title>
	<meta name="description" content="GoriniDrive, like Google Drive.. but Gorini">
	<meta name="author" content="Francesco Gorini">
	<link rel="manifest" href="/manifest.json">
	<link rel="stylesheet" media="screen and (min-width: 601px)" href="styles/style_main_desktop.css" />
	<link rel="stylesheet" media="screen and (max-width: 600px)" href="styles/style_main_mobile.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
	<div class="action_result_div">
		<p></p>
	</div>
	<div class="nav">
		<img class="logo" src="res/logo.png">
		<h1 class="welcome_header">Welcome <?php echo $username?></h1>
		<div class="menu_btn">
			<div class="bar1"></div>
			<div class="bar2"></div>
			<div class="bar3"></div>
		</div>
	</div>
	<div class="wrapper">
		<div class="left_column">
			<div class="server_info">Server
				<p class="server_status">Status: Online <i class="fas fa-globe-americas"></i></p>
				<p class="server_temp">Temperature: <b></b> <i class="fas fa-temperature-low"></i></p>
				<p class="server_since"><i class="fas fa-clock"></i></p>
			</div>
		</div>

		<div class="center_column">
			<div class="files_list">
				<div class="file example">
					<div class="details">
						<p class="name">name</p>
						<p class="size">size</p>
						<p class="date">date uploaded</p>
					</div>
					<div class="actions"><p>Actions</p></div>
				</div>
				<div class='upload_file_button'><i class='fas fa-file-upload upload'></i></div>
			</div>
			<div class="upload_file_div">
				<h3>Select file to upload</h3>
				<p>Max file size is <?php echo (int)(ini_get('upload_max_filesize'));?> MB</p>
				<form action="utils/file_upload.php" method="post" enctype="multipart/form-data" class="upload_file_form">
					<input type="file" name="fileToUpload" class="file_to_upload">
					<input type="submit" value="Upload file" name="submit" class="upload_file_btn">
				</form>
			</div>
			<div class="div_to_close_upload_div"></div>
		</div>

		<div class="menu">
			<a href="#">About</a>
			<a href="http://francescogorini.com">francescogorini.com</a>
			<a href="utils/logout.php"> Logout <i class="fas fa-sign-out-alt"></i></a>
		</div>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="scripts/script.js"></script>
<script>
//FUNCTION FOR DISPLAYING MESSAGE AFTER UPLOAD/DELETE
function display_status(response){
	$(".action_result_div p").html(response);
	$(".action_result_div").addClass("action_result_div_visible");
	window.setTimeout(function(){
		$(".action_result_div").removeClass("action_result_div_visible");
	}, 5000);
}
</script>
<?php
if(isset($_GET["status"])){
	echo "<script> display_status('".$_GET["status"]."'); </script>";
}
?>
</html>
