<?php  
    $result = $blog->read();
?>

<section class="ftco-section bg-light" id="blog-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <h2 class="mb-4">Bài viết</h2>
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