<?php

    include 'includes/database.php';
    include 'includes/subscribers.php';
    include 'includes/check_login.php';
    include 'includes/users.php';

    $user = new User($db);
    $user->n_user_id = $_SESSION['user_id'];
    $user->read_single();

    $subscriber = new Subscriber($db);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['delete_subscriber'])) {
            
            $subscriber->n_sub_id = $_POST['sub_id'];
            if ($subscriber->delete()) {
                header('Location: blog_subscribers.php');
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
    <title>Blog Subscribers</title>

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
                                    <h2 class="title-1">Blog Subscribers</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $result = $subscriber->read();
                                                $num = $result->rowCount();
                                                if ($num > 0):
                                                    while ($rows = $result->fetch()):
                                            ?>
                                            <tr>
                                                <td><?php echo $rows['n_sub_id']; ?></td>
                                                <td><?php echo $rows['v_sub_email']; ?></td>
                                                <td><?php echo $rows['f_sub_status']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-subscriber<?php echo $rows['n_sub_id']; ?>">Delete</button>
                                                </td>
                                            </tr>
                                            <?php
                                                    endwhile;
                                                endif;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                        </div>
                        <?php include 'footer.php';?>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->

            <?php
                $result = $subscriber->read();
                $num = $result->rowCount();
                if ($num > 0):
                    while ($rows = $result->fetch()):
            ?>

			<div class="modal fade" id="delete-subscriber<?php echo $rows['n_sub_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Delete Subscriber</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Do you want to delete this subscriber?</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="sub_id" value="<?php echo $rows['n_sub_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_subscriber">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

            <?php
                    endwhile;
                endif;
            ?>

            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <?php include 'script.php'; ?>

</body>

</html>
<!-- end document-->
