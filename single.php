<?php  
    include 'header.php';

    $blog->n_blog_post_id = $_GET['id'];
    $blog->read_single();
    $newest_blogs = $blog->read_newest_blogs();
    $cate = $category->read();

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        if(isset($_POST['submit_comment'])){
            $comment->n_blog_comment_parent_id = 0;
            $comment->n_blog_post_id = $_GET['id'];
            $comment->v_comment_author = $_POST['c_name'];
            $comment->v_comment_author_email = $_POST['c_email'];
            $comment->v_comment = $_POST['c_message'];
            $comment->d_date_created = date('y-m-d',time());
            $comment->d_time_created = date('h:i:s',time());
            if ($comment->create()) {
                redirect();
            }
        }

        if(isset($_POST['submit_comment_reply'])){
            $comment->n_blog_comment_parent_id = $_POST['blog_comment_id'];
            $comment->n_blog_post_id = $_GET['id'];
            $comment->v_comment_author = $_POST['c_name_reply'];
            $comment->v_comment_author_email = $_POST['c_email_reply'];
            $comment->v_comment = $_POST['c_message_reply'];
            $comment->d_date_created = date('y-m-d',time());
            $comment->d_time_created = date('h:i:s',time());
            if ($comment->create()) {
                redirect();
            }
        }

        redirect();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'meta.php'; ?>

    <?php include 'style.php'; ?>

    <title>Trí Blog - <?php echo $blog->v_post_title; ?></title>
    
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300" onload="hide_form_reply();">

    <?php include 'navbar.php'; ?>

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_4.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ <i
                                    class="fa fa-chevron-right"></i></a></span> <span class="mr-2"><a
                                href="index.php#blog-section">Bài viết <i class="fa fa-chevron-right"></i></a></span> <span>Chi tiết
                            <i class="fa fa-chevron-right"></i></span></p>
                    <h1 class="mb-0 bread"><?php echo $blog->v_post_title; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 ftco-animate">
                    <h2 class="mb-3"><?php echo $blog->v_post_title; ?></h2>
                    <?php echo html_entity_decode($blog->v_post_content); ?>
                    <div class="tag-widget post-tag-container mb-5 mt-5">
                        <div class="tagcloud">
                            <?php
                                $tag->n_blog_post_id = $blog->n_blog_post_id;
                                $tag->read_single();
                                $tag_arr = explode(', ', $tag->v_tag);
                                foreach ($tag_arr as $tag_element):
                            ?>
                            <a href="search.php?q=<?php echo $tag_element; ?>"><?php echo $tag_element; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php
                        $comment->n_blog_post_id = $_GET['id'];
                        $comment_list = $comment->read_single_blog_post();
                        $num_comment = $comment_list->rowCount();    
                    ?>
                    <div class="pt-5 mt-5">
                        <h4 class="mb-5 font-weight-bold"><?php echo $num_comment; ?> bình luận</h4>
                        <ul class="comment-list">

                            <?php while ($comment_item = $comment_list->fetch()) { ?>
                            <li class="comment">
                                <div class="vcard bio">
                                    <img src="images/person_1.jpg" alt="Image placeholder">
                                </div>
                                <div class="comment-body">
                                    <h3><?php echo $comment_item['v_comment_author'] ?></h3>
                                    <div class="meta"><?php echo $comment_item['d_date_created'] . ' ' . $comment_item['d_time_created']; ?></div>
                                    <p><?php echo $comment_item['v_comment'] ?></p>
                                    <p><a href="#reply" class="reply" onclick="reply_comment(<?php echo $comment_item['n_blog_comment_id']?>)">Reply</a></p>
                                </div>

                                <?php
                                    $comment->n_blog_comment_id = $comment_item['n_blog_comment_id'];
                                    $reply_list = $comment->read_single_blog_post_reply();  
                                    while ($reply_item = $reply_list->fetch()) {
                                ?>
                                <ul class="children">
                                    <li class="comment">
                                        <div class="vcard bio">
                                            <img src="images/person_1.jpg" alt="Image placeholder">
                                        </div>
                                        <div class="comment-body">
                                            <h3><?php echo $reply_item['v_comment_author'] ?></h3>
                                            <div class="meta"><?php echo $reply_item['d_date_created'] . ' ' . $reply_item['d_time_created']; ?></div>
                                            <p><?php echo $reply_item['v_comment'] ?></p>
                                        </div>
                                    </li>
                                </ul>
                                <?php } ?>
                            </li>
                            <?php } ?>

                        </ul>
                        <!-- END comment-list -->

                        <div class="comment-form-wrap pt-5" id="respond">
                            <h3 class="mb-5">Bài viết có hay, xin hãy bình luận!</h3>
                            <form action="" class="p-5 bg-light" method="post" name="c_form" onsubmit="return check_respond()">
                                <div class="form-group">
                                    <label for="name">Tên của bạn</label>
                                    <input type="text" class="form-control" id="name" name="c_name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Địa chỉ email của bạn</label>
                                    <input type="email" class="form-control" id="email" name="c_email">
                                </div>
                                <div class="form-group">
                                    <label for="message">Tin nhắn</label>
                                    <textarea id="message" cols="30" rows="5" class="form-control" name="c_message"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Đăng" class="btn py-3 px-4 btn-primary" name="submit_comment">
                                </div>
                            </form>
                        </div>

                        <div class="comment-form-wrap pt-5" id="reply">
                            <h3 class="mb-5">Trả lời bình luận</h3>
                            <form action="" class="p-5 bg-light" method="post" name="c_form_reply" onsubmit="return check_reply()">
                                <div class="form-group">
                                    <label for="name">Tên của bạn</label>
                                    <input type="text" class="form-control" id="name" name="c_name_reply">
                                </div>
                                <div class="form-group">
                                    <label for="email">Địa chỉ email của bạn</label>
                                    <input type="email" class="form-control" id="email" name="c_email_reply">
                                </div>
                                <div class="form-group">
                                    <label for="message">Tin nhắn</label>
                                    <textarea id="message" cols="30" rows="5" class="form-control" name="c_message_reply"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="blog_comment_id">
                                    <input type="submit" value="Trả lời" class="btn py-3 px-4 btn-primary" name="submit_comment_reply">
                                </div>
                            </form>
                        </div>
                    </div>

                </div> <!-- .col-md-8 -->
                <div class="col-lg-4 sidebar ftco-animate">
                    <div class="sidebar-box ftco-animate">
                        <h3 class="heading-sidebar">Danh mục</h3>
                        <ul class="categories">
                            <?php 
                                while($rows = $cate->fetch()) { 
                                    $blog->n_category_id = $rows['n_category_id'];
                                    $blog_result = $blog->read_blog_by_category();
                                    if ($blog_result->rowCount() > 0) {
                            ?>
                            <li><a href="cate_search.php?id=<?php echo $rows['n_category_id']; ?>"><?php echo $rows['v_category_title']; ?></a></li>
                            <?php 
                                    }
                                } 
                            ?>
                        </ul>
                    </div>

                    <div class="sidebar-box ftco-animate">
                        <h3 class="heading-sidebar">Bài viết mới nhất</h3>
                        <?php while($rows = $newest_blogs->fetch()) { ?>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4" style="background-image: url(images/upload/<?php echo $rows['v_main_image_url']; ?>);"></a>
                            <div class="text">
                                <h3 class="heading"><a href="single.php?id=<?php echo $rows['n_blog_post_id']; ?>"><?php echo $rows['v_post_title']; ?></a></h3>
                                <div class="meta">
                                    <div><a href="#"><span class="icon-calendar"></span> <?php echo $rows['d_date_created']; ?></a></div>
                                    <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                                    <div><a href="#"><span class="icon-eye"></span> <?php echo $rows['n_blog_post_views']; ?></a></div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                </div>

            </div>
        </div>
    </section> <!-- .section -->

    <?php include 'footer.php'; ?>

    <?php include 'script.php'; ?>

</body>

</html>