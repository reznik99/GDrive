<?php
//connect to database
require 'connect_to_db.php';
session_start();
// error_reporting(E_ALL); ini_set('display_errors', 1);

if (isset($_POST['login'])) {
  //prevent XSS and script injection
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);

  //prevent SQL Injection
  $stmt = $mysql_con->prepare("SELECT user_name, password_hash FROM users WHERE user_name = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $error = $stmt->error;
  $result = $stmt->get_result();
  $values = $result->fetch_assoc();
  $stmt->close();
  $mysql_con->close();

  //correct password (passowrd verify encrypts password and checks with already encrypted password)
  if (password_verify($password, $values['password_hash'])) {
    $_SESSION['valid'] = true;
    $_SESSION['timeout'] = time();
    $_SESSION['username'] = $values['user_name'];
    header('Location:index.php');
  }else{
    //show error
    header('Location:login.php?status=Wrong username or password!');
  }
  exit();
}

if (isset($_POST['signup'])) {
  //prevent XSS and script injection
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);
  $password_repeat = htmlspecialchars($_POST['password_repeat']);

  $passwords_are_identical = $password==$password_repeat;
  //hash
  $password = password_hash($password, PASSWORD_DEFAULT);

  if($passwords_are_identical){
    //prevent SQL Injection
    //check if username is available
    $usr_exists = $mysql_con->prepare("SELECT user_name FROM users WHERE user_name = ?");
    $usr_exists->bind_param('s', $username);
    $usr_exists->execute();
    $usr_exists->store_result();
    $usr_exists = $usr_exists->num_rows > 0;

    if(!$usr_exists){
      $stmt = $mysql_con->prepare("INSERT INTO users (user_name, password_hash) VALUES (?, ?)");
      $stmt->bind_param("ss", $username, $password);
      $success = $stmt->execute();
      // $error = $stmt->error;
      $stmt->close();
      $mysql_con->close();

      if ($success) {
        //successful signup
        header('Location:login.php?status=Successfully signed up new account! '.$username);
      }else{
        //failed signup | query or other error
        header('Location:login.php?status=Signup Failed!');
      }
    }else{
      //failed signup | username taken
      header('Location:login.php?status=Signup Failed! Username already in use!');
    }
  }else{
    //failed signup | passwords not same
    header('Location:login.php?status=Signup Failed! Passwords are not the same!');
  }
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Francesco Gorini</title>
  <meta name="description" content="GoriniDrive, like Google Drive.. but Gorini">
  <meta name="author" content="Francesco Gorini">
  <link rel="manifest" href="/manifest.json">
  <link rel="stylesheet" media="screen and (min-width: 601px)" href="style_login_desktop.css" />
  <link rel="stylesheet" media="screen and (max-width: 600px)" href="style_login_mobile.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>
</head>
<body>
  <!-- OUTPUT -->
  <div class="action_result_div"><p></p></div>
  <!-- LOG IN -->
  <div class="log_in_wrapper">
    <img class="logo" src="src/logo.png">
    <form method="POST" class="log_in_form">
      <input class="input_field" name="username" type="text" placeholder="Username" autocorrect="off" autocapitalize="none" required ></input>
      <input class="input_field" name="password" type="password" placeholder="Password" autocorrect="off" autocapitalize="none" required></input>
      <div class="button_holder">
        <button type="submit" class="submit" name="login">Log In <i class="submit_icon fas fa-arrow-right"></i></button>
        <p class="between_buttons">or</p>
        <a class="toggle_divs">Sign Up <i class="fas fa-user-plus"></i></a>
      </div>
    </form>
  </div>
  <!-- SIGN UP -->
  <div class="log_in_wrapper hidden">
    <img class="logo" src="src/logo.png">
    <form method="POST" class="log_in_form">
      <input class="input_field" name="username" type="text" placeholder="Username" autocorrect="off" autocapitalize="none" required ></input>
      <input class="input_field" name="password" type="password" placeholder="Password" autocorrect="off" autocapitalize="none" required></input>
      <input class="input_field" name="password_repeat" type="password" placeholder="Repeat Password" autocorrect="off" autocapitalize="none" required></input>
      <div class="button_holder">
        <button type="submit" class="submit" name="signup">Sign Up <i class="submit_icon fas fa-arrow-right"></i></button>
        <p class="between_buttons">or</p>
        <a class="toggle_divs">Log in <i class="fas fa-sign-in-alt"></i></a>
      </div>
    </form>
  </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="script_login.js"></script>
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
