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
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Devil Blog</title>
  <?php require_once('includes/css.php') ?>
  
  <!-- ck_editor -->
  <script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
  
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
            <a class="btn btn-primary" href="index.php">Dashboard Home</a>
          </li>

          <li class="nav-item">
            <a class="btn btn-primary ml-2" href="/logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- //navbar -->

  <header class="masthead">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="page-heading">
            <h1>Admin Panel</h1>
            <span class="subheading">Manage your posts</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <?php

    
    $id = $_GET['id'] ?? null;
    
    if ( is_numeric($id) == true){

    $sql = "SELECT * FROM `posts` WHERE sno = :id ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(); 
    
        $iid = $row['sno'];
        $taglin = $row['tagline'];
        $titl = $row['title'];
        $conten = $row['content'];
    
    }
    
  ?>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        
        <form name="sentMessage" id="contactForm" action="" method="post" novalidate>
          <div class="control-group">
            <input type="hidden" name="snoEdit" id="snoEdit" value="<?php echo $iid ?>">
            <div class="form-group floating-label-form-group controls">
              <label>Title</label>
              <input type="text" class="form-control" placeholder="Title" id="title" name='title' value="<?php echo $titl; ?>">
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Tagline</label>
              <input type="text" class="form-control" placeholder="Tagline" id="tagline" name="tagline" value="<?php echo $taglin; ?>">
              <p class="help-block text-danger"></p>
            </div>
          </div>
         
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>content</label>
              <textarea rows="5" class="form-control" placeholder="Content" name="content" id="content"  ><?php echo $conten; ?></textarea>
              <p class="help-block text-danger"></p>
            </div>
          </div>

          <!-- <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Image File</label>
              <input class="form-control" placeholder="Image Filename" name="img_file" id="img_file" value="{{post.img_file}}">
              <p class="help-block text-danger"></p>
            </div>
          </div> -->


          <br>
          <div id="success"></div>
          <div class="form-group">
            <button name="submit" type="submit" class="btn btn-success border border-dark rounded-lg" id="sendMessageButton">Submit</button>
            <?php
            if (isset($_POST['submit'])) {
      
        // Update the record
        $sno = $_POST["snoEdit"];
        $title = $_POST["title"];
        $tagline = $_POST["tagline"];
        $content = $_POST["content"];

        // Sql query to be executed
        $sql = "UPDATE `posts` SET `title` = '$title' , `tagline`='$tagline', `content` = '$content' WHERE `sno` = $sno";
        $stm = $conn->prepare($sql);
        $stm->execute();
        if ($stm) {
                  echo "<script>alert('updated successfully')</script>";                
                } else {
                  echo "<script>alert('updated unsuccessfull')</script>";
                }
    
  }
            ?>
          </div>
        </form>
      </div>
    </div>
  </div>
  <hr>

  <!-- Footer -->
  <footer>
    <p class="copyright text-muted">Copyright &copy; Devil Blog 2020</p>
  </footer>

   <?php require_once('includes/js.php') ?>
   
  <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace( 'content' );
            </script>

</body>

</html>