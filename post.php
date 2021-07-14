<?php
//ini_set('session.cookie_httponly',1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
header('X-Content-Type-Options: nosniff');
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options:DENY");
header("Content-Security-Policy: frame-ancestors 'none'",false);

?>

<?php require_once('includes/connect.php') ?>

<?php

$slug = $_GET['post'] ?? null;
          try{
$sql = "SELECT * FROM `posts` WHERE slug = :slug";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':slug', $slug);
$stmt->execute();
$row = $stmt->fetch();

}catch(PDOException $e){
  echo 'Error: '.$e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="how to">
  <meta name="description" content="how to fix">
  <meta name="description" content="<?php echo $row['title'] ?>">
  <meta name="google-site-verification" content="qZObdeYj-BXB98_HOsYMeYG2xZNSfQuOsWs6fwIpgiI" />

  <title><?php echo $row['title'] ?></title>
  <?php require_once('includes/post_css.php') ?>
  
</head>

<body>
    
<!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <a class="navbar-brand" href="#">Dhruv Blog</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php require_once('includes/post_nav.php') ?>
    </ul>
  </div>
</nav>


<!-- Page Header -->
<header class="masthead" style="background-image: url('https://github.com/jakbin/blog/raw/main/post-bg.jpg')">  
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="post-heading">
          <?php

            echo "   

            <h1>" . $row['title'] . "</h1>
          
            <span class='post-meta'>Posted by Devil " . $row['date'] . " </sapn>
             
            ";
            
            echo "<hr>";
          
          ?>

        </div>
      </div>
    </div>
  </div>
</header>

<!-- Post Content -->
<article>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <?php

          echo $row['content'];
        
        ?>
      </div>
    </div>
  </div>
</article>

<!-- footer -->

<?php include('includes/footer.php') ?>
