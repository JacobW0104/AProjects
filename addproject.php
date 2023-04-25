<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aprojects</title>
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

        session_start();

        error_reporting(E_ALL ^ E_WARNING);

        require_once ("connectdb.php");

      if (isset($_SESSION["username"])){    
        echo "<br><br><h1>Add a Project!</h1><br><p>Logged in as ".$_SESSION['username']."</p>";

        echo '<form method="post" action="addproject.php">
        <p>Title:</p><input type="text" name="title" required=""><br>
        <br>
        <p>Start Date:</p><input type="date" name="projectStartDate" required=""><br>
        <br>
        <p>End Date:</p><input type="date" name="projectEndDate" required=""><br>
        <br>
        <label for="phase">Phase: </label>
        <br>
          <select name="phase" id="phase">
            <option value="design">Design</option>
            <option value="development">Development</option>
            <option value="testing">Testing</option>
            <option value="deployment">Deployment</option>
            <option value="complete">Completed</option>
          </select>
        <br>
        <br>
        <label>Project Description:<br>
        <textarea name="description" rows="4" cols="40" required=""></textarea></label><br>
        <div class="submit">
          <input type="submit" value="Add" class="tbl_btn"> <input type="hidden" name="addproject" value="true">';

      }

      if (isset($_POST["addproject"])){
    
        $title=isset($_POST["title"])?$_POST["title"]:false;
        $startDate=isset($_POST["projectStartDate"])?$_POST["projectStartDate"]:false;
        $endDate=isset($_POST["projectEndDate"])?$_POST["projectEndDate"]:false;
        $phase=isset($_POST["phase"])?$_POST["phase"]:false;
        $description=isset($_POST["description"])?$_POST["description"]:false;
    
        try{

          $user = $db->query("SELECT * FROM users WHERE username ='".$_SESSION['username']."'")->fetch();
    
          $stat = $db->prepare('INSERT INTO `projects` (`pid`, `title`, `start_date`, `end_date`, `phase`, `description`, `uid`) VALUES (NULL, ?, ?, ?, ?, ?, ?)');
          $stat->execute(array($title, $startDate, $endDate, $phase, $description, $user['uid']));
          header("Location:projects.php");
    
        } catch (PDOexception $ex){
          $error = TRUE;
        }
    
      }
      ?>
    </div>
  </main>
</body>
</html>