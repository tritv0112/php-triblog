<?php

    include 'includes/database.php';
    include 'includes/blogs.php';
    include 'includes/tags.php';
    include 'includes/check_login.php';
    include 'includes/users.php';

    $user = new User($db);
    $user->n_user_id = $_SESSION['user_id'];
    $user->read_single();

    $blog = new Blog($db);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['create_blog'])) {

            $target_file = '../images/upload/';
            if (!empty($_FILES['main_image']['name'])) {
                $main_image = $_FILES['main_image']['name'];
                move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file . $main_image);
            } else {
                $main_image = '';
            }

            $target_file = '../images/upload/';
            if (!empty($_FILES['alt_image']['name'])) {
                $alt_image = $_FILES['alt_image']['name'];
                move_uploaded_file($_FILES['alt_image']['tmp_name'], $target_file . $alt_image);
            } else {
                $alt_image = '';
            }

            $opt = (!empty($_POST['opt_place'])) ? $_POST['opt_place'] : 0;

            $blog->n_category_id = $_POST['select_category'];	
            $blog->v_post_title = $_POST['title'];	
            $blog->v_post_meta_title = $_POST['meta_title'];	
            $blog->v_post_path = $_POST['blog_path'];	
            $blog->v_post_summary = $_POST['blog_summary'];	
            $blog->v_post_content = $_POST['blog_content'];	
            $blog->v_main_image_url = $main_image;
            $blog->v_alt_image_url = $alt_image;
            $blog->n_blog_post_views = 0;
            $blog->n_home_page_placement = 1;
            $blog->f_post_status = $opt;
            $blog->d_date_created = date('Y-m-d', time());
            $blog->d_time_created = date('h:i:s', time());

            if ($blog->create()) {
                // Write blog tag
                $tag = new Tag($db);
                $tag->n_blog_post_id = $blog->last_id();
                $tag->v_tag = $_POST['blog_tags'];
                $tag->create();
                header('Location: blogs.php');
            }
        }

        if (isset($_POST['update_blog'])) {

            $target_file = '../images/upload/';
            if (!empty($_FILES['main_image']['name'])) {
                $main_image = $_FILES['main_image']['name'];
                move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file . $main_image);
            } else {
                $main_image = $_POST['old_main_image'];
            }

            $target_file = '../images/upload/';
            if (!empty($_FILES['alt_image']['name'])) {
                $alt_image = $_FILES['alt_image']['name'];
                move_uploaded_file($_FILES['alt_image']['tmp_name'], $target_file . $alt_image);
            } else {
                $alt_image = $_POST['old_alt_image'];
            }

            $opt = (!empty($_POST['opt_place'])) ? $_POST['opt_place'] : 0;

            // Params
            $blog->n_blog_post_id = $_POST['blog_id'];	
            $blog->n_category_id = $_POST['select_category'];	
            $blog->v_post_title = $_POST['title'];	
            $blog->v_post_meta_title = $_POST['meta_title'];	
            $blog->v_post_path = $_POST['blog_path'];	
            $blog->v_post_summary = $_POST['blog_summary'];	
            $blog->v_post_content = $_POST['blog_content'];	
            $blog->v_main_image_url = $main_image;
            $blog->v_alt_image_url = $alt_image;
            $blog->n_blog_post_views = $_POST['post_view'];	
            $blog->n_home_page_placement = $opt;
            $blog->f_post_status = $_POST['status'];
            $blog->d_date_created = $_POST['date_created'];	
            $blog->d_time_created = $_POST['time_created'];	
            $blog->d_date_updated = date('Y-m-d', time());
            $blog->d_time_updated = date('h:i:s', time());
            
            if ($blog->update()) {
                header('Location: blogs.php');
            }

        }

        if (isset($_POST['delete_blog'])) {
            $tag = new Tag($db);
            $tag->n_blog_post_id = $_POST['blog_id'];
            $tag->delete();

            if ($_POST['main_image'] != '') {
                unlink('../images/upload/' . $_POST['main_image']);
            }

            if ($_POST['alt_image'] != '') {
                unlink('../images/upload/' . $_POST['alt_image']);
            }

            $blog->n_blog_post_id = $_POST['blog_id'];
            if ($blog->delete()) {
                header('Location: blogs.php');
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
    <title>Blogs</title>

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
                                    <h2 class="title-1">Blogs</h2>
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
                                                <th>Title</th>
                                                <th>Views</th>
                                                <th>Home Page placement</th>
                                                <th class="col-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $result = $blog->read();
                                                $num = $result->rowCount();
                                                if ($num > 0):
                                                    while ($rows = $result->fetch()):
                                            ?>
                                            <tr>
                                                <td><?php echo $rows['n_blog_post_id']; ?></td>
                                                <td><?php echo $rows['v_post_title']; ?></td>
                                                <td><?php echo $rows['n_blog_post_views']; ?></td>
                                                <td><?php echo $rows['n_home_page_placement']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="location.href='../single.php?id=<?php echo $rows['n_blog_post_id']; ?>'">View</button>
                                                    <button type="button" class="btn btn-warning btn-sm" onclick="location.href='edit_blog.php?id=<?php echo $rows['n_blog_post_id']; ?>'">Edit</button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-blog<?php echo $rows['n_blog_post_id']; ?>">Delete</button>
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
                $result = $blog->read();
                $num = $result->rowCount();
                if ($num > 0):
                    while ($rows = $result->fetch()):
            ?>

			<div class="modal fade" id="delete-blog<?php echo $rows['n_blog_post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Delete Blog</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Do you want to delete this blog?</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_name" value="delete_blog">
                                <input type="hidden" name="main_image" value="<?php echo $rows['v_main_image_url']; ?>">
                                <input type="hidden" name="alt_image" value="<?php echo $rows['v_alt_image_url']; ?>">
                                <input type="hidden" name="blog_id" value="<?php echo $rows['n_blog_post_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_blog">Yes</button>
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
