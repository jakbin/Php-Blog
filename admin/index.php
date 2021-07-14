<?php require_once('includes/connect.php') ?>
<?php
ini_set('session.cookie_httponly',1);
//header("X-Frame-Options:DENY");
//header("Content-Security-Policy: frame-ancestors 'none'",false);
session_start();

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();    
}

$insert = false;
$update = false;
$delete = false;

if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;
  $sq = "DELETE FROM `posts` WHERE `sno` = :sno";
  $delete = $conn->prepare($sq);
  $delete->bindParam(':sno', $sno);
  $delete->execute();
}


?>
<?php

$no_of_posts = 5;

if(isset($_GET['page'])){
  $page = $_GET['page'] ?? null;
}else{
  $page = 1;
}
if ( is_numeric($page) == true){
$offset = ($page - 1) * $no_of_posts ;
}

$post_query_count = "SELECT * FROM `posts`";
$find_count = $conn->prepare($post_query_count);
$find_count->execute();
$total_records = $find_count->rowCount();
$total_page = ceil($total_records / $no_of_posts);

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Devil Blog</title>
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
            <a class="nav-link" href="msg.php">Messages</a>
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
            <span class="subheading">Manage your posts</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <h1>Add a new post</h1>
        <a href="add.php"><button class="btn btn-primary border border-dark rounded-lg">Add a new post</button></a>
        <br>
        <hr>
        <!-- <hr> -->

        <!-- <h1>Upload A file</h1>
        <form action="/upload" method="POST" enctype="multipart/form-data">
          <input type="file" name="file1">
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <br> -->
        <?php require_once('includes/connect.php') ?>


        <?php $sql = "SELECT * FROM `posts` ORDER BY `sno`DESC  LIMIT $offset,$no_of_posts ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch()) {


          echo "<div class='post-preview'>
        <a href='/test-blog/post.php?id=" . $row['sno'] . "'>
          <h2 class='post-title'>
               " . $row['title'] . "
        
          </h2>
          <h3 class='post-subtitle'>
           
          " . $row['tagline'] . "
          </h3>
        </a>
        <p class='post-meta'>Posted by
          <a href='#'>Devil</a>
          " . $row['date'] . " </p>
      
      ";
        
      $my_string = ($row['content']);
      $word = explode(' ', $my_string);
      $five_words = array_slice($word,0,10);
      $string_of_five_words = implode(' ' ,$five_words)."\n";
      echo $string_of_five_words.".............";
      echo " </div>";
          
          echo '<br><a href="edit.php?id=' . $row['sno'] . '"><button class="btn btn-warning border border-dark rounded-lg">Edit</button></a></td>
                <button class="delete btn btn-danger border border-dark rounded-lg" id=d'.$row["sno"].'>Delete</button></td>';
          echo "<hr>";
        }

        ?>
        <!-- pager -->
        <!-- Pager -->
      <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
<?php

        // previous button
        if ( is_numeric($page) == true){  
        if ($page>=1){
          if ($page==1) {
            echo '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
          }else{
            echo '<li class="page-item"><a class="page-link" href="index.php?page='.($page-1).'">Previous</a></li>';
          } 
        }

        
        if ($total_page==$page) {
          $i = $page;  
          foreach (range($i-2,$i-1) as $n) {
              echo '<li class="page-item"><a class="page-link" href="index.php?page='.$n.'">'.$n.'</a></li>';
            }
            echo '<li class="page-item active"><span class="page-link">'.$i.'<span class="sr-only">(current)</span></span></li>';  
        }

        else if ($page==$total_page-1) {
          $i = $page;
          $l = $i-1;
            echo '<li class="page-item"><a class="page-link" href="index.php?page='.$l.'">'.$l.'</a></li>';
            echo '<li class="page-item active"><span class="page-link">'.$i.'<span class="sr-only">(current)</span></span></li>';
            $j = $i+1;
            echo '<li class="page-item"><a class="page-link" href="index.php?page='.$j.'">'.$j.'</a></li>';
          
        }else {
          $i = $page;
            echo '<li class="page-item active"><span class="page-link">'.$i.'<span class="sr-only">(current)</span></span></li>';
            $k=$i+1;
          foreach (range($k,$k+1) as $n) {
              echo '<li class="page-item"><a class="page-link" href="index.php?page='.$n.'">'.$n.'</a></li>';
            }
        }
        
        // next button
        if ($page<=$total_page){
          if ($page==$total_page) {
            echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
          }else{
            echo '<li class="page-item"><a class="page-link" href="index.php?page='.($page+1).'">Next</a></li>';
          }
        }
      }
 ?>
    </ul>               
</nav>
        
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer>

    <p class="copyright text-muted">Copyright &copy; Devil Blog 2020</p>

  </footer>

   <?php require_once('includes/js.php') ?>
   <script>
  deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this post!")) {
          console.log("yes");
          window.location = `index.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
</script>
   
</body>

</html>