<?php require_once('includes/connect.php') ?>
<?php
session_start();
if (isset($_POST['submit'])) {
    $user = $_POST['user'];
    $user = filter_var($user, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $sql = " SELECT * FROM adimn WHERE usr = ?";
    $sq = "SELECT * FROM `adimn`";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$user]);
    $row = $stmt->rowCount();

    $stm = $conn->prepare($sq);
    $stm->execute();
    $pas = $stm->fetch();
    	$passd = $pas['pss'];    
    
    $passv = password_verify($pass, $passd);
        if($row == 1 AND $passv ){
            $_SESSION['user'] = $user;
            header('location:index.php');
        } else{
            header('location:login.php');
        }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN LOGIN PAGE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.5.1.slim.js"></script>
     <link rel="shortcut icon" href="https://github.com/jak3456/ak/raw/master/devil.ico" type="image/x-icon">
</head>

<body>
    
        <div class="container center-div shadow">
            <div class="heading text-center text-uppercase text-white mb-5 mt-2">ADMIN LOGIN PAGE</div>
            <div class="container row d-flex flex-row justify-content-center mb-5">
                <div class="admin-form shadow p-2">
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="username">Email ID</label>
                            <input type="text" name="user" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="pass">Email ID</label>
                            <input type="password" name="pass" value="" class="form-control">
                        </div>
                        <input type="submit" class="btn btn-success" name="submit">
                    </form>
                </div>
            </div>
        </div>
    
</body>

</html>