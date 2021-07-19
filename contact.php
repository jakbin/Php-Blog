<?php require_once('includes/head_section.php') ?>

<?php require_once('includes/connect.php') ?>

<?php require_once('includes/contact_css.php') ?>
<?php
     session_start();
    if (! isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    
      $message1 = '';
      $message2 = '';
      $message3 = '';

if (isset($_POST['submit'])) {
    if (!empty($_POST['token'])) {
    
        if (hash_equals($_SESSION['token'], $_POST['token'])) {
        
          $name = $_POST["name"];
          if (!empty($name)) {
            $namef = true;
          }else{
            $namef = false;
            $message1 =  "<center><h4 style='color: red;'>please fill name!</h4></center>";
          }
          $email = $_POST["email"];
          if (!empty($email)) {
            $emailf = true;
          }else{
            $emailf = false;
            $message2 = "<center><h4 style='color: red;'>please fill emailid!</h4></center>";
          }
          $message = $_POST["message"];
          if (!empty($message)) {
            $messagef = true;
          }else{
            $messagef = false;
            $message3 = "<center><h4 style='color: red;'>please fill message!</h4></center>";
          }
          if ($namef AND $emailf AND $messagef) {
              // Sql query to be executed
              $sql = "INSERT INTO `msg` (`sno`, `name`, `email`, `message`, `date`) VALUES (NULL, ?, ?, ?, current_timestamp())";
              $edit = $conn->prepare($sql);
              $edit->execute([$name,$email,$message]);
              if ($edit) {
                echo "<script>alert('your message has been sent')</script>";
                }
          }
        }else{
        die("csrf token validation failed");
    }
    } else{
        die("csrf token not available");
    }
}
?>
  
<body>
    <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <a class="navbar-brand" href="#">Dhruv Blog</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php require_once('includes/contact_nav.php') ?>
    </ul>
  </div>
</nav>
    <section>
        <form name="sentMessage" id="contactForm" action="" method="POST" novalidate>
        <div class="containr">
            <div class="contactform">
                <h2>Contact Us</h2>
                <div class="formbox">
                     <input type="hidden", name="token", value='<?php echo $_SESSION["token"] ?>'/>
                    <div class="inputbox w50">
                        <?php  echo $message1 ?>
                        <input name="name" type="text" name="" required>
                        <span>First Name</span>
                    </div>
                    <div class="inputbox w50">
                        <?php  echo $message2 ?>
                        <input name="email" type="text" name="" required>
                        <span>Email Address</span>
                    </div>
                    <div class="inputbox w100">
                        <?php  echo $message3 ?>
                        <textarea name="message" name="" id="" required></textarea>
                        <span>Write your message here...</span>
                    </div>
                    <div class="inputbox w100">
                        <input name="submit" type="submit" value="Send">
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>
</body>

</html>