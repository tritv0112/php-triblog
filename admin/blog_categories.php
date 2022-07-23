<?php

    include 'includes/database.php';
    include 'includes/categories.php';
    include 'includes/check_login.php';
    include 'includes/users.php';

    $user = new User($db);
    $user->n_user_id = $_SESSION['user_id'];
    $user->read_single();

    $category = new Category($db);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_POST['form_name'] == 'add_category') {
            $title = $_POST['category_title'];
            $metaTitle = $_POST['category_meta_title'];
            $path = $_POST['category_path'];

            // Bind Params
            $category->v_category_title = $title;
            $category->v_category_meta_title = $metaTitle;
            $category->v_category_path = $path;
            $category->d_date_created = date('Y/m/d', time()); 
            $category->d_time_created = date('h:i:s', time());
            
            if ($category->create()) {
                header('Location: blog_categories.php');
            }

        }

        if ($_POST['form_name'] == 'edit_category') {
            $title = $_POST['category_title'];
            $metaTitle = $_POST['category_meta_title'];
            $path = $_POST['category_path'];
            $id = $_POST['category_id'];

            // Bind Params
            $category->n_category_id = $id;
            $category->v_category_title = $title;
            $category->v_category_meta_title = $metaTitle;
            $category->v_category_path = $path;
            $category->d_date_created = date('Y/m/d', time()); 
            $category->d_time_created = date('h:i:s', time());
            
            if ($category->update()) {
                header('Location: blog_categories.php');
            }

        }

        if ($_POST['form_name'] == 'delete_category') {
            $id = $_POST['category_id'];

            // Bind Params
            $category->n_category_id = $id;
            if ($category->delete()) {
                header('Location: blog_categories.php');
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
    <title>Blog Categories</title>

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
                                    <h2 class="title-1">Blog Categories</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Add Category</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form role="form" method="POST" action="">
                                            <div class="form-group">
                                                <label for="title" class="form-control-label">Title</label>
                                                <input type="text" id="title" name="category_title" placeholder="Enter title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_title" class="form-control-label">Meta Title</label>
                                                <input type="text" id="meta_title" name="category_meta_title" placeholder="Enter meta title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="path" class="form-control-label">Path</label>
                                                <input type="text" id="path" name="category_path" placeholder="Enter path" class="form-control">
                                            </div>
                                            <input type="hidden" name="form_name" value="add_category">
                                            <button type="submit" class="btn btn-primary">Add Category</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Meta Title</th>
                                                <th>Path</th>
                                                <th class="col-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $result = $category->read();
                                                $num = $result->rowCount();
                                                if ($num > 0):
                                                    while ($rows = $result->fetch()):
                                            ?>
                                            <tr>
                                                <td><?php echo $rows['n_category_id']; ?></td>
                                                <td><?php echo $rows['v_category_title']; ?></td>
                                                <td><?php echo $rows['v_category_meta_title']; ?></td>
                                                <td><?php echo $rows['v_category_path']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="location.href='../cate_search.php?id=<?php echo $rows['n_category_id']; ?>'">View</button>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit-category<?php echo $rows['n_category_id']; ?>">Edit</button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-category<?php echo $rows['n_category_id']; ?>">Delete</button>
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
                $result = $category->read();
                $num = $result->rowCount();
                if ($num > 0):
                    while ($rows = $result->fetch()):
            ?>

			<div class="modal fade" id="edit-category<?php echo $rows['n_category_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Title</label>
                                    <input type="text" id="title" name="category_title" placeholder="Enter title" class="form-control" value="<?php echo $rows['v_category_title']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="meta_title" class="form-control-label">Meta Title</label>
                                    <input type="text" id="meta_title" name="category_meta_title" placeholder="Enter meta title" class="form-control" value="<?php echo $rows['v_category_meta_title']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="path" class="form-control-label">Path</label>
                                    <input type="text" id="path" name="category_path" placeholder="Enter path" class="form-control" value="<?php echo $rows['v_category_path']; ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_name" value="edit_category">
                                <input type="hidden" name="category_id" value="<?php echo $rows['n_category_id']; ?>">
                                <button type="submit" class="btn btn-warning">OK</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

            <div class="modal fade" id="delete-category<?php echo $rows['n_category_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Delete Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Do you want to delete this category?</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_name" value="delete_category">
                                <input type="hidden" name="category_id" value="<?php echo $rows['n_category_id']; ?>">
                                <button type="submit" class="btn btn-danger">Yes</button>
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
