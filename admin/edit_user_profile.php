<?php

    include 'includes/database.php';
    include 'includes/check_login.php';
    include 'includes/users.php';

    $user = new User($db);
    $user->n_user_id = $_SESSION['user_id'];
    $user->read_single();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['update_user_profile'])) {

            if(empty($_FILES['image_profile']['name'])){
                $image_name = $_POST['old_image_profile'];            
            }else{
                $target_file = "../images/avatars/";            
                $image_name = $_FILES['image_profile']['name'];
                move_uploaded_file($_FILES['image_profile']['tmp_name'],$target_file.$image_name);
            }

            $user->v_fullname = $_POST['name'];
            $user->v_email = $_POST['email'];
            $user->v_username = $_POST['username'];
            $user->v_password = (!empty($_POST['password'])) ? md5($_POST['password']) : $_POST['old_password'];
            $user->v_phone = $_POST['phone'];
            $user->v_image = $image_name;
            $user->v_message = $_POST['about'];

            if ($user->update()) {
                header('Location: edit_user_profile.php');
            }

        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'meta.php'; ?>
    <?php include 'style.php'; ?>

    <!-- Title Page-->
    <title>Edit User Profile</title>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <?php include 'sidebar.php'; ?>

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <?php include 'header.php'; ?>

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Edit User Profile</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Edit User Profile</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form role="form" method="POST" action="" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="name">Full name</label>
                                                <input type="text" id="name" name="name" value="<?php echo $user->v_fullname; ?>" placeholder="Enter full name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" id="email" name="email" value="<?php echo $user->v_email; ?>" placeholder="Enter email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" id="password" name="password" placeholder="Enter password" class="form-control">
                                                <input type="hidden" name="old_password" value="<?php echo $user->v_password; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Phone Number</label>
                                                <input type="text" id="phone" name="phone" value="<?php echo $user->v_phone; ?>" placeholder="Enter phone number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Image Profile</label>
                                                <br/>
                                                <input type="file" name="image_profile">
                                                <input type="hidden" name="old_image_profile" value="<?php echo $user->v_image; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="about">About me</label>
                                                <textarea class="form-control" id="summernote_profile" name="about"><?php echo htmlspecialchars_decode($user->v_message); ?></textarea>
                                            </div>
                                            <input type="hidden" name="username" value="<?php echo $user->v_username; ?>">
                                            <button type="submit" class="btn btn-warning" name="update_user_profile">
                                                <i class="fa fa-check"></i> Update Profile</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>User Avatar</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <img src="../images/avatars/<?php echo $user->v_image; ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include 'footer.php';?>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <?php include 'script.php'; ?>

</body>

</html>
<!-- end document-->
