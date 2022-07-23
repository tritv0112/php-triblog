<?php  
    include 'header.php';

    $result = $blog->read_blog_by_query($_GET['q']);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'meta.php'; ?>

    <?php include 'style.php'; ?>

    <title>Trí Blog - Tìm kiếm</title>
    
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300" onload="hide_form_reply();">

    <?php include 'navbar.php'; ?>

    <section class="ftco-section bg-light" id="blog-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-5">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <span class="subheading">Tìm kiếm</span>
                    <h2 class="mb-4"><?php echo $_GET['q']; ?></h2>
                    <p>Các bài viết có từ khóa <b><?php echo $_GET['q']; ?></b></p>
                </div>
            </div>
            <div class="row d-flex">
                <?php while($rows = $result->fetch()) { ?>
                <div class="col-md-4 d-flex ftco-animate">
                    <div class="blog-entry justify-content-end">
                        <a href="single.php?id=<?php echo $rows['n_blog_post_id'] ?>" class="block-20" style="background-image: url('images/upload/<?php echo $rows['v_main_image_url'] ?>');">
                        </a>
                        <div class="text mt-3 float-right d-block">
                            <div class="d-flex align-items-center mb-3 meta">
                                <p class="mb-0">
                                    <span class="mr-2"><?php echo $rows['d_date_created']; ?></span>
                                    <a href="#" class="mr-2">Admin</a>
                                    <a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a>
                                </p>
                            </div>
                            <h3 class="heading"><a href="single.php?id=<?php echo $rows['n_blog_post_id'] ?>"><?php echo $rows['v_post_title']; ?></a>
                            </h3>
                            <p><?php echo $rows['v_post_summary']; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <?php include 'script.php'; ?>

</body>

</html>