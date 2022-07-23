<?php  
    include "admin/includes/database.php";
    include "admin/includes/subscribers.php";
    include "admin/includes/blogs.php";
    include "admin/includes/tags.php";

    $database = new Database();
    $db = $database->connect();

    $tag = new Tag($db);      
    $blog = new Blog($db);
    $blog_list = $blog->read_active_blog();

    if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['email'])!=""){
            $subscriber = new Subscriber($db);
            $subscriber->v_sub_email = $_POST['email'];
            $subscriber->d_date_created = date('y-m-d',time());
            $subscriber->d_time_created = date('h:i:s',time());
            $subscriber->f_sub_status = 1;
            $subscriber->create();       
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'meta.php'; ?>
    <?php include 'style.php'; ?>
    <title>HoaTC - Home</title>

</head>

<body>

    <?php include 'navbar.php'; ?>

    <?php include 'banner.php'; ?>

    <section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url(images/bg_3.jpg);"
        data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row d-md-flex align-items-center justify-content-end">
                <div class="col-lg-10">
                    <div class="row d-md-flex align-items-center">
                        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18">
                                <div class="text">
                                    <strong class="number" data-number="18">0</strong>
                                    <span>Bài viết</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18">
                                <div class="text">
                                    <strong class="number" data-number="351">0</strong>
                                    <span>Liên hệ</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18">
                                <div class="text">
                                    <strong class="number" data-number="564">0</strong>
                                    <span>Lượt đăng ký</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18">
                                <div class="text">
                                    <strong class="number" data-number="300">0</strong>
                                    <span>Tổng truy cập</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-start mb-5 pb-2">
                <div class="col-md-4 heading-section ftco-animate">
                    <span class="subheading subheading-with-line"><small class="pr-2 bg-white">Bài viết</small></span>
                    <h2 class="mb-4">Mới nhất</h2>
                </div>
            </div>
            <div class="row">
                <?php while($blog_item = $blog_list->fetch()): ?>
                <div class="col-md-4 ftco-animate">
                    <div class="blog-entry">
                        <a href="read_blog.php?id=<?php echo $blog_item['n_blog_post_id'] ?>" class="block-20"
                            style="background-image: url('admin/images/upload/<?php echo $blog_item['v_main_image_url'] ?>');">
                        </a>
                        <div class="text d-flex py-4">
                            <div class="meta mb-3">
                                <div><a href="#"><?php echo $blog_item['d_date_created']; ?></a></div>
                                <div><a href="#">Admin</a></div>
                                <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>
                            </div>
                            <div class="desc pl-3">
                                <h3 class="heading"><a href="read_blog.php?id=<?php echo $blog_item['n_blog_post_id'] ?>"><?php echo $blog_item['v_post_title']; ?></a></h3>
                                <p class="blog-summary"><?php echo $blog_item['v_post_summary']; ?></p>
                                <div class="tag-widget post-tag-container">
                                    <div class="tagcloud">
                                        <?php
                                            $tag->n_blog_post_id = $blog_item['n_blog_post_id'];
                                            $tag->read_single();
                                            $tag_arr = explode(', ', $tag->v_tag);
                                            foreach ($tag_arr as $tag_item):
                                        ?>
                                        <a href="search.php?q=<?php echo $tag_item; ?>"><?php echo $tag_item; ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <?php include 'script.php'; ?>

</body>

</html>