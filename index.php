<?php require_once('includes/head_section.php') ?>

<?php require_once('includes/index_css.php') ?>

</head>
<?php require_once('includes/connect.php') ?>
<body onload="myfunction()">
 <div id="loading">
  <section>
    <svg>
        <filter id="gooey">
            <feGaussianBlur id="SourceGraphic" stdDeviation="10"/>
        <feColorMatrix values="
                       1 0 0 0 0
                       0 1 0 0 0
                       0 0 1 0 0
                       0 0 0 20 -10"></feColorMatrix>
        </feGaussianBlur>
        </filter>
    </svg>
    <div class="loader">
        <span style="--i:1;"></span>
        <span style="--i:2;"></span>
        <span style="--i:3;"></span>
        <span style="--i:4;"></span>
        <span style="--i:5;"></span>
        <span style="--i:6;"></span>
        <span style="--i:7;"></span>
        <span style="--i:8;"></span>
        <span class="rotate" style="--j:0;"></span>
        <span class="rotate" style="--j:1;"></span>
        <span class="rotate" style="--j:2;"></span>
        <span class="rotate" style="--j:3;"></span>
        <span class="rotate" style="--j:4;"></span>
    </div>
</section>
 </div>

<!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <a class="navbar-brand" href="#">Dhruv Blog</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php require_once('includes/index_nav.php') ?>
    </ul>
  </div>
</nav>

<!-- Page Header -->
<header class="masthead" style="background-image: url('https://github.com/jakbin/blog/raw/main/home-bg.jpg')">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="site-heading">
          <h1>Devil Blog</h1>
          <span class="subheading">A blog by Devil</span>
        </div>
      </div>
    </div>
  </div>
</header>

<?php


$no_of_posts = 4;

if(isset($_GET['page'])){
  $page = $_GET['page'];
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

<!-- Main Content -->
<div class="containr">
  <div class="row ro">
    <div class="col-lg-8 col-md-10 mx-auto dj ">
      <?php
      $sql = "SELECT * FROM `posts` ORDER BY `sno` DESC  LIMIT $offset,$no_of_posts ";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $z =1;
      while ($row = $stmt->fetch() AND $z<5) {

        
        echo "

        <div class='post-preview jd shadow".$z++."' style='color: #000000'>
        <a href='post.php?post=" . $row['slug'] . "'>
        
          <h2 class='post-title'> " . $row['title'] . " </h2>
          
        </a>
        <p class='post-meta' style='color: #000000'>Posted by
          <a href='#'>Devil</a>" . $row['date'] . " </p><div style='font-size: 25px'>
          
        ";
        
      $my_string = ($row['content']);
      echo substr($my_string,0,30);
      echo ".................";
      echo "</div></div>";
      }

      ?>

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

<!-- footer -->
<?php include('includes/footer.php') ?>
<script>
            var preloader = document.getElementById('loading');
            function myfunction(){
              preloader.style.display = 'none';
            }

  </script>