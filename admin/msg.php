<?php require_once('includes/connect.php') ?>
<?php

ini_set('session.cookie_httponly',1);
header("X-Frame-Options:DENY");
header("Content-Security-Policy: frame-ancestors 'none'",false);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();    
}

if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;
  $sq = "DELETE FROM `msg` WHERE `sno` = :sno";
  $delete = $conn->prepare($sq);
  $delete->bindParam(':sno', $sno);
  $delete->execute();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Devil Blog</title>
  <link rel="icon" href="img/fav_icon.jpg" type="image/x-icon">

   <?php require_once('includes/css.php') ?>

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="/">Devil Blog</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/msg.php">Message</a>
          </li>

          <li class="nav-item">
            <a class="btn btn-danger rounded-lg" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- to do add a image in header -->
  <header class="masthead">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="page-heading">
            <h1>Admin Panel</h1>
            <span class="subheading">Manage your users message</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <br>

        <?php require_once('includes/connect.php') ?>


        <?php $sql = "SELECT * FROM `msg` ORDER BY `sno` DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch()) {


          echo "<div class='post-preview'>
        " . $row['sno'] ."
          <h3 class='post-title'>
               " . $row['name'] . "
        
          </h3>
          
        
        <p class='post-meta'>Sent by
          <a href='#'><b>" . $row['email'] . "</b></a>
          " . $row['date'] . " </p>
      </div>";
          echo $row['message'];
          echo '<br>
                <button name="delete" class=" delete btn btn-danger border border-dark rounded-lg" id=d'.$row["sno"].'>Delete</button>';
          echo "<hr>";
        }

        ?>

        
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer>

    <p class="copyright text-muted">Copyright &copy; Devil Blog 2020</p>

  </footer>
<script>
  deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this post!")) {
          console.log("yes");
          window.location = `msg.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
</script>
  <?php require_once('includes/js.php') ?>

</body>

</html>