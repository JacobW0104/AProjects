<?php 

   if (isset($_POST["submitted"])){

    require_once('connectdb.php');

    try{
      $stat = $db->prepare('SELECT password FROM users WHERE username = ?');
			$stat->execute(array($_POST['username']));
    
      if ($stat->rowCount()>0){
        $row=$stat->fetch();

        if (password_verify($_POST["password"], $row["password"])){

          session_start();
          $_SESSION["username"]=$_POST["username"];
          header("Location:projects.php");
          exit();

        } else {
          $passEr = TRUE;
        }

      } else {
        $userEr = TRUE;
      }
    } catch (PDOException $ex) {
      $dbEr = TRUE;
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
    global $passEr, $userEr, $dbEr;
    if ($passEr == TRUE){
      echo "<h3 style='color:red; font-size: 15px'>Password does not match</h3>";
    }
    if ($userEr == TRUE){
      echo "<h3 style='color:red; font-size: 15px'>Username not found</h3>";
    }
    if ($dbEr == TRUE){
      echo "<h3 style='color:red; font-size: 15px'>Failed to connect to the database</h3>";
    }
    echo "<br>"
      ?>
      <h2>Login</h2>
      <br>
      <form method="post" action="login.php">
        <p>Username:</p><input type="text" name="username" required="">
        <br>
        <p>Password:</p><input type="password" name="password" required=""><br>
        <br>
        <input type="submit" value="Login" class='tbl_btn'>
        <input type="hidden" name="submitted" value="true">
      </form>
      <br>
        <a href="signup.php">Click here to sign-up!</a>
    </div>
    
  </main>
</body>
</html>