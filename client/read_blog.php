<?php  
    include "admin/includes/database.php";
    include "admin/includes/subscribers.php";
    include "admin/includes/blogs.php";
    include "admin/includes/tags.php";
    include "admin/includes/comments.php";
    $database = new Database();
    $db = $database->connect();

    $comment = new Comment($db);
    $tag = new Tag($db);      
    $blog = new Blog($db);
    $popular_blog_list = $blog->read_popular_blog();

    $blog->n_blog_post_id = $_GET['id'];
    $blog->read_single();

    if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['email'])!=""){
            $subscriber = new Subscriber($db);
            $subscriber->v_sub_email = $_POST['email'];
            $subscriber->d_date_created = date('y-m-d',time());
            $subscriber->d_time_created = date('h:i:s',time());
            $subscriber->f_sub_status = 1;
            $subscriber->create();
        }

        if(isset($_POST['submit_comment'])){
            $comment->n_blog_comment_parent_id = 0;
            $comment->n_blog_post_id = $_GET['id'];
            $comment->v_comment_author = $_POST['c_name'];
            $comment->v_comment_author_email = $_POST['c_email'];
            $comment->v_comment = $_POST['c_message'];
            $comment->d_date_created = date('y-m-d',time());
            $comment->d_time_created = date('h:i:s',time());
            $comment->create();
        }

        if(isset($_POST['submit_comment_reply'])){
            $comment->n_blog_comment_parent_id = $_POST['blog_comment_id'];
            $comment->n_blog_post_id = $_GET['id'];
            $comment->v_comment_author = $_POST['c_name_reply'];
            $comment->v_comment_author_email = $_POST['c_email_reply'];
            $comment->v_comment = $_POST['c_message_reply'];
            $comment->d_date_created = date('y-m-d',time());
            $comment->d_time_created = date('h:i:s',time());
            $comment->create();
        }

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <?php include 'meta.php'; ?>
    <?php include 'style.php'; ?>
    <title>Mosaic - Free Bootstrap 4 Template by Colorlib</title>
    
</head>

<body onload="hide_form_reply();">

    <?php include 'navbar.php'; ?>

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread"><?php echo $blog->v_post_title; ?></h1>
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="index.php">Home 
                                <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </span> 
                        <span class="mr-2">
                            <a href="blogs.php">Blog 
                                <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </span> 
                        <span>
                            Blog Single 
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
                <div class="col-lg-8 ftco-animate">
                    <p>
                        <img src="admin/images/upload/<?php echo $blog->v_main_image_url; ?>" alt="" class="img-fluid">
                    </p>
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

                    <div class="about-author d-flex p-4 bg-light">
                        <div class="bio mr-5">
                            <img src="images/person_1.jpg" alt="Image placeholder" class="img-fluid mb-4">
                        </div>
                        <div class="desc">
                            <h3>George Washington</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque, autem
                                necessitatibus voluptate quod mollitia delectus aut, sunt placeat nam vero culpa
                                sapiente consectetur similique, inventore eos fugit cupiditate numquam!</p>
                        </div>
                    </div>

                    <?php
                        $comment->n_blog_post_id = $_GET['id'];
                        $comment_list = $comment->read_single_blog_post();
                        $num_comment = $comment_list->rowCount();    
                    ?>
                    <div class="pt-5 mt-5">
                        <h3 class="mb-5 h4 font-weight-bold"><?php echo $num_comment; ?> Comments</h3>
                        <ul class="comment-list">
                            <?php while ($comment_item = $comment_list->fetch()): ?>
                            <li class="comment">
                                <div class="vcard bio">
                                    <img src="images/person_1.jpg" alt="Image placeholder">
                                </div>
                                <div class="comment-body">
                                    <h3><?php echo $comment_item['v_comment_author'] ?></h3>
                                    <div class="meta mb-2"><?php echo $comment_item['d_date_created'] . ' ' . $comment_item['d_time_created']; ?></div>
                                    <p><?php echo $comment_item['v_comment'] ?></p>
                                    <p><a href="#" class="reply" onclick="reply_comment(<?php echo $comment_item['n_blog_comment_id']?>)">Reply</a></p>
                                </div>
                                
                                <?php
                                    $comment->n_blog_comment_id = $comment_item['n_blog_comment_id'];
                                    $reply_list = $comment->read_single_blog_post_reply();  
                                    while ($reply_item = $reply_list->fetch()):
                                ?>
                                <ul class="children">
                                    <li class="comment">
                                        <div class="vcard bio">
                                            <img src="images/person_1.jpg" alt="Image placeholder">
                                        </div>
                                        <div class="comment-body">
                                            <h3><?php echo $reply_item['v_comment_author'] ?></h3>
                                            <div class="meta mb-2"><?php echo $reply_item['d_date_created'] . ' ' . $reply_item['d_time_created']; ?></div>
                                            <p><?php echo $reply_item['v_comment'] ?></p>
                                        </div>
                                    </li>
                                </ul>
                                <?php endwhile; ?>
                                
                            </li>
                            <?php endwhile; ?>
                        </ul>
                        <!-- END comment-list -->

                        <div class="comment-form-wrap pt-5" id="respond">
                            <h3 class="mb-5 h4 font-weight-bold">Leave a comment</h3>
                            <form name="c_form" class="p-5 bg-light" onsubmit="return check_respond()" id="contactForm" method="post" action="" autocomplete="off">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="c_name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="c_email">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea name="c_message" id="message" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Post Comment" class="btn py-3 px-4 btn-primary" name="submit_comment">
                                </div>
                            </form>
                        </div>

                        <div class="comment-form-wrap pt-5" id="reply">
                            <h3 class="mb-5 h4 font-weight-bold">Reply to: </h3>
                            <form name="c_form_reply" class="p-5 bg-light" onsubmit="return check_reply()" id="contactForm" method="post" action="" autocomplete="off">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="c_name_reply">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="c_email_reply">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea name="c_message_reply" id="message" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="blog_comment_id">
                                    <input type="submit" value="Post Reply" class="btn py-3 px-4 btn-primary" name="submit_comment_reply">
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- .col-md-8 -->

                <div class="col-lg-4 sidebar ftco-animate">
                    <div class="sidebar-box">
                        <form action="#" class="search-form">
                            <div class="form-group">
                                <span class="icon icon-search"></span>
                                <input type="text" class="form-control" placeholder="Type a keyword and hit enter">
                            </div>
                        </form>
                    </div>
                    <div class="sidebar-box ftco-animate">
                        <h3>Category</h3>
                        <ul class="categories">
                            <li><a href="#">Interior Design <span>(6)</span></a></li>
                            <li><a href="#">Exterior Design <span>(8)</span></a></li>
                            <li><a href="#">Industrial Design <span>(2)</span></a></li>
                            <li><a href="#">Landscape Design <span>(2)</span></a></li>
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