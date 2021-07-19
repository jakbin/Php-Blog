<?php require_once('includes/connect.php') ?>
<?php
session_start();
if (! isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }

$message = '';
if (isset($_POST['submit'])) {
    if (!empty($_POST['token'])) {
    
        if (hash_equals($_SESSION['token'], $_POST['token'])) {

    $user = $_POST['user'];
    $user = filter_var($user, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $sql = " SELECT * FROM adimn WHERE usr = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user]);
    $row = $stmt->rowCount();

        if($row == 1 ){
            $sq = "SELECT * FROM `adimn`";
            $stm = $conn->prepare($sq);
            $stm->execute();
            $pas = $stm->fetch();
            $passd = $pas['pss'];
            $passv = password_verify($pass, $passd);
            if ($passv) {
                    $_SESSION['user'] = $user;
            header('location:index.php');
            }else{
              $message = "wrong password or username";
            }          
            
        } else{
            $message = "wrong username or password";
        }

        }else{
        die("csrf token validation failed");
        }
    } else{
        die("csrf token not available");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
    <style type="text/css">
    	*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

section{
    position: relative;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background:#fbff00;
}

section::before{
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 50%;
    height: 100%;
    background: #1b00ff;
}

section .container{
    position: relative;
    min-width:  100%;
    min-height: 550px;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

section .container .contactform {
    position: absolute;
    
    background: #fff;
    margin-top: 6%;
    margin-left: 18%;
    margin-right: 15%;
    padding-top: 4%;
    padding-left: 4%;
    padding-right: 4%;
    box-shadow: 0 50px 50px rgba(0, 0, 0, 0.5);
}

@media screen and (max-width: 480px){
    section .container .contactform{
        margin-top: 50%;
    margin-left: 8%;
    margin-right: 8%;
    padding-top: 4%;
    padding-left: 2%;
    padding-right: 0%;
    }
}

section .container .contactform h2{
    text-align: center;
    color: #0f3959;
    font-size: 24px;
    font-weight: 500;
}

section .container .contactform .formbox{
    position: relative;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    padding: 30px;
}

@media screen and (max-width: 480px){
    section .container .contactform .formbox{
    position: relative;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    padding: 30px;
    }
    section .container .contactform .formbox .inputbox.w50{
        padding-bottom: 21px;
    }
}

 section .container .contactform .formbox .inputbox{
     width: 100%;
     display: inline;
    position: relative;
    margin: 0 0 35px 0;
}


section .container .contactform .formbox .inputbox.w100{
    width: 100%;
}

section .container .contactform .formbox .inputbox input,
section .container .contactform .formbox .inputbox textarea
{
    width: 100% !important;
    padding: 5px 0;
    resize: none;
    font-size: 18px;
    font-weight: 300;
    color: #333;
    border: none;
    border-bottom: 2px solid #333;
    outline: none;
}

 section .container .contactform .formbox .inputbox textarea{
    min-height: 120px;
} 

section .container .contactform .formbox .inputbox span{
    position: absolute;
    left: 0;
    padding: 5px 0;
    
    font-size: 18px;
    font-weight: 300;
    color: #333;
    transition: 0.5s;
    pointer-events: none;
}

section .container .contactform .formbox .inputbox input:focus ~ span,
section .container .contactform .formbox .inputbox textarea:focus ~span,
section .container .contactform .formbox .inputbox input:valid ~ span,
section .container .contactform .formbox .inputbox textarea:valid ~span
{
    transform: translateY(-20px);
    font-size: 12px;
    font-weight: 400;
    letter-spacing: 1px;
    color: #ff568c;
}

section .container .contactform .formbox .inputbox input[type="submit"]{
    position: relative;
    background: #0f3959;
    color: #fff;
    border: none;
    max-width: 150px;
    padding: 12px;
}


section .container .contactform .formbox .inputbox input[type="submit"]:hover
{
   background: #ff568c;
}
    </style>
</head>

<body>
    <section>
        <div class="container">
        <?php echo $message; ?>
            <div class="contactform">
                <h2>Login</h2>
                <form class="formbox" action="login.php" method="POST">
                     <input type="hidden", name="token", value='<?php echo $_SESSION["token"] ?>'/>
                
                    <div class="inputbox w50">
                        <input type="text" id="uname" name="user" placeholder="User Name" required>
                        <span>User Name</span>
                    </div>
                    
                    
                    <div class="inputbox w50">
                        <input type="password" namid="pass" name="pass" placeholder="Password" autocomplete="off" autocomplete="new-password" required>
                        <span>Password</span>
                    </div>
                    
                    <div class="inputbox w100">
                        <input type="submit" value="Submit" name="submit">
                    </div>
                
            </div>
            </form>
        </div>

    </section>
</body>

</html>
