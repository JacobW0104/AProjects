<?php

  if (isset($_POST["submitted"])){

    require_once('connectdb.php');

    $username=isset($_POST["username"])?$_POST["username"]:false;
    $email=isset($_POST["email"])?$_POST["email"]:false;
    $password=isset($_POST["password"])?password_hash($_POST['password'],PASSWORD_DEFAULT):false;

    if (!($username)){
      echo "username wrong";
      exit;
    }
    if (!($email)){
      echo "email wrong";
      exit;
    }
    if (!($password)){
      echo "password wrong";
      exit;
    }

    try{

      $stat = $db->prepare('INSERT INTO `users` (`uid`, `username`, `password`, `email`) VALUES (NULL, ?, ?, ?)');
			$stat->execute(array($username, $password, $email));
      header("Location:login.php");

    } catch (PDOexception $ex){
      $error = TRUE;
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AProjects</title>
  <link rel="icon" href="./images/favicon.ico?v=2" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="./CSS/style.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
  <script defer src="./js/basic.js"></script>
</head>
<body>
  <nav class="navbar">
    <div class="logo">
      <em>AProjects</em>
    </div>
    <ul class="nav-links">
      <li>
        <a href="projects.php">Projects</a>
      </li>
      <li>
        <a href="login.php">Login/Sign-up</a>
      </li>
    </ul>
  </nav>
  <main> 
    <div class="main-text">
    <?php 
    global $created, $error;
    if ($created == TRUE){
      echo "<h3>Sign-Up Sucessful!</h3>";
    }
    if ($error == TRUE){
      echo "<h3 style='color:red'>Failed to connect to the database</h3>";
    }
    echo "<br>"
      ?>
      <h2>Sign-Up</h2>
      <br>
      <form method="post" action="signup.php">
        <p>Username:</p><input type="text" name="username" required="">
        <br>
        <p>Email:</p><input type="email" name="email" required="">
        <br>
        <p>Password:</p><input type="password" name="password" required=""><br>
        <br>
        <input type="submit" value="Sign-up" class='tbl_btn'>
        <input type="hidden" name="submitted" value="true">
      </form>
      <br>
      <a href="login.php">Already have an account? Click here to Log-In!</a>
    </div>
    
  </main>
</body>
</html>