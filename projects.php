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
      <form method="get" action="projects.php" class="search-bar">
        <input type="text" placeholder="Search..." name="q" id="search">
        <button type="submit"><img src="./images/search-icon-free-vector.jpg"></button>
        <input type="hidden" name="submitted" value="true">
      </form>
      <?php

        session_start();

        error_reporting(E_ALL ^ E_WARNING);

        require_once ("connectdb.php");

        if (isset($_SESSION["username"])){ 
          echo "<p>Logged in as ".$_SESSION['username']."</p><br><h1>Projects:</h1>";
        }

        try{

          if ($_GET["q"]){
              $query="SELECT * FROM projects WHERE title LIKE '%".$_GET['q']."%'";
              $rows = $db->query($query);
          } else {
            $query="SELECT * FROM projects ";
            $rows = $db->query($query);
          }

          if ($rows && $rows->rowCount()>0){

          ?>
        <table>
        <tr><th align='left'><b>Title</b></th> <th align='left'><b>Start Date</b></th> <th align='left'><b>Description</b></th ><th align='left'></th></tr>
        <?php
          while  ($row =  $rows->fetch())	{
            $rowquote = '"'.$row['pid'].'"';
            $rowquote2 = '"'.$row['uid'].'"';
				    echo  "<tr><td align='left'><button class='tbl_btn' onclick='open2($rowquote)'>" . $row['title'] . "</button></td>";
				    echo  "<td align='left'>" . $row['start_date'] . "</td>";
				    echo "<td align='left'>". $row['description'] . "</td>";
            
            $userOfSession =  $db->query("SELECT * FROM users WHERE username ='".$_SESSION['username']."'")->fetch();
            if ($row['uid'] == $userOfSession['uid']){
              echo "<td align='left'>
              <form method='post' action='projects.php'>
                <button value='edit' class='tbl_btn'>Edit</button>
                <input type='hidden' name='edit' value=$rowquote />
              </form></td></tr>\n";
            }

            $email = $db->query("SELECT * FROM users WHERE uid =".$rowquote2."")->fetch();
            echo "<div id='".$row['pid']."' class='popup'><p>Project Title: ".$row['title']."<br>Start Date: ".$row['start_date']."<br>
            End Date: ".$row['end_date']."<br>Phase: ".$row['phase']."<br>Description: ".$row['description']."<br>User's Email: ".$email['email']."<br> 
            </p><button onclick='close2($rowquote)'>Close</button></div>";
			    }
			    echo  '</table>';
        } else {
          echo "<p>No Projects</p>";
        }
      } catch (PDOException $ex) {
        $dbEr = TRUE;
        //echo($ex->getMessage());
      }

      if (isset($_SESSION["username"])){ 
        $addPage = '"'.'addproject.php'.'"';
        echo "<br><button class='tbl_btn' onclick='window.location.href=".$addPage."';>Add a Project!</button>";
        echo "<br><br><br><form method='post' action='projects.php'>
          <button value='logout' class='tbl_btn'>Logout</button>
          <input type='hidden' name='logout' value='true' />
          </form></td></tr>\n";
      }
    
      if (isset($_POST["edit"])){ 
        $_SESSION["edit"] = $_POST["edit"];
        header("Location:changeproject.php");
        exit();
      }

      if (isset($_POST["logout"])){ 
        session_destroy();
        header("Location:projects.php");
        exit();
      }
      ?>
    </div>
  </main>
</body>
</html>