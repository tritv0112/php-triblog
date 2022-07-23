<?php  
    include "admin/includes/database.php";
    include "admin/includes/subscribers.php";
    include "admin/includes/blogs.php";
    include "admin/includes/tags.php";
    include "admin/includes/comments.php";

    $database = new Database();
    $db = $database->connect();

    $tag = new Tag($db);
    $blog = new Blog($db);
    $comment = new Comment($db);
    $offset = 6;
    $total_page = ceil($blog->read_active_blog()->rowCount() / $offset);
    $current_page = (isset($_GET['page'])) ? $_GET['page'] - 1 : 0;
    $blog_from = $current_page * $offset;
    $blog_list = $blog->read_active_blog_by_page($blog_from, $offset);
    $popular_blog_list = $blog->read_popular_blog();

    if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['email'])!=""){
            $subscriber = new subscribe($db);
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
    <title>HoaTC - Blogs</title>
    
</head>

<body>

    <?php include 'navbar.php'; ?>

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread">Tất cả bài viết</h1>
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="index.html">Trang chủ 
                                <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </span> 
                        <span>Bài viết 
                            <i class="ion-ios-arrow-forward"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <?php while($blog_item = $blog_list->fetch()): ?>
                        <div class="col-md-6 ftco-animate">
                            <div class="blog-entry">
                                <a href="read_blog.php?id=<?php echo $blog_item['n_blog_post_id'] ?>" class="block-20" 
                                    style="background-image: url('admin/images/upload/<?php echo $blog_item['v_main_image_url'] ?>');"></a>
                                <div class="text d-flex py-4">
                                    <div class="meta mb-3">
                                        <div><a href="#"><?php echo $blog_item['d_date_created']; ?></a></div>
                                        <div><a href="#">Admin</a></div>
                                        <div><a href="#"><span class="icon-eye"></span> <?php echo $blog_item['n_blog_post_views']; ?></a></div>
                                        <div><a href="#" class="meta-chat"><span class="icon-chat"></span> <?php echo $comment->read_comment_reply_by_blog_id($blog_item['n_blog_post_id'])->rowCount(); ?></a></div>
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
                    <div class="row no-gutters my-5">
                        <div class="col text-center">
                            <div class="block-27">
                                <ul>
                                    <?php if ($current_page > 0): ?>
                                    <li><a href="blogs.php?page=<?php echo $current_page; ?>">&lt;</a></li>
                                    <?php endif; ?>
                                    <?php for($i = 0; $i < $total_page; $i++): ?>
                                    <li><a href="blogs.php?page=<?php echo $i+1; ?>"><?php echo $i+1; ?></a></li>
                                    <?php endfor; ?>
                                    <?php if ($current_page < $total_page - 1): ?>
                                    <li><a href="blogs.php?page=<?php echo $current_page+2; ?>">&gt;</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 sidebar ftco-animate">
                    <div class="sidebar-box ftco-animate">
                        <h3>Chuyên mục</h3>
                        <ul class="categories">
                            <?php
                                $category_list = $category->read(); 
                                while ($category_item = $category_list->fetch()): 
                            ?>
                            <li><a href="blog_categories.php?id=<?php echo $category_item['n_category_id'] ?>">
                                <?php echo $category_item['v_category_title'] ?>
                                <span>2 bài viết</span>
                            </a></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>

                    <div class="sidebar-box ftco-animate">
                        <h3>Bài viết nổi bật</h3>
                        <?php while($popular_blog_item = $popular_blog_list->fetch()): ?>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4" style="background-image: url('admin/images/upload/<?php echo $popular_blog_item['v_main_image_url'] ?>');"></a>
                            <div class="text">
                                <h3 class="heading"><a href="read_blog.php?id=<?php echo $popular_blog_item['n_blog_post_id'] ?>"><?php echo $popular_blog_item['v_post_title']; ?></a></h3>
                                <div class="meta">
                                    <div><a href="#"><span class="icon-calendar"></span> <?php echo $popular_blog_item['d_date_created']; ?></a></div>
                                    <div><a href="#"><span class="icon-person"></span> Dave Lewis</a></div>
                                    <div><a href="#"><span class="icon-eye"></span> <?php echo $popular_blog_item['n_blog_post_views']; ?></a></div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="sidebar-box ftco-animate">
                        <h3>Tag Cloud</h3>
                        <ul class="tagcloud m-0 p-0">
                            <a href="#" class="tag-cloud-link">House</a>
                            <a href="#" class="tag-cloud-link">Office</a>
                            <a href="#" class="tag-cloud-link">Land</a>
                            <a href="#" class="tag-cloud-link">Building</a>
                            <a href="#" class="tag-cloud-link">Table</a>
                            <a href="#" class="tag-cloud-link">Intrior</a>
                            <a href="#" class="tag-cloud-link">Exterior</a>
                        </ul>
                    </div>

                    <div class="sidebar-box ftco-animate">
                        <h3>Archives</h3>
                        <ul class="categories">
                            <li><a href="#">December 2018 <span>(30)</span></a></li>
                            <li><a href="#">Novemmber 2018 <span>(20)</span></a></li>
                            <li><a href="#">September 2018 <span>(6)</span></a></li>
                            <li><a href="#">August 2018 <span>(8)</span></a></li>
                        </ul>
                    </div>


                    <div class="sidebar-box ftco-animate">
                        <h3>Paragraph</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque, autem
                            necessitatibus voluptate quod mollitia delectus aut, sunt placeat nam vero culpa sapiente
                            consectetur similique, inventore eos fugit cupiditate numquam!</p>
                    </div>
                </div><!-- END COL -->
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <?php include 'script.php'; ?>

</body>

</html>