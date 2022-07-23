<?php  
    include "includes/database.php";
    include "includes/users.php";

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $user = new User($db);
        $user->v_username = $_POST['username'];
        $user->v_password = md5($_POST['password']);
        $result = $user->login();
        $num = $result->rowCount();
        $row_user = $result->fetch();

        if ($num>0) {
            session_start();
            $_SESSION['user_id'] = $row_user['n_user_id'];
            header("location: index.php");
        } else {
            $flag = "Login false!";
        }  
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'meta.php'; ?>
    <?php include 'style.php'; ?>
    <title>Login</title>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="images/icon/logo.png" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="au-input au-input--full" type="text" name="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">Remember Me
                                    </label>
                                    <label>
                                        <a href="#">Forgotten Password?</a>
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-t-10 m-b-10" type="submit">sign in</button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Don't you have account?
                                    <a href="#">Sign Up Here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include 'script.php'; ?>

</body>

</html>
<!-- end document-->