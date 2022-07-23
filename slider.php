<section id="home-section" class="hero">
    <div class="home-slider owl-carousel">
        <?php  
            $slider_list = $blog->read_home_page_placement();
            while($slider_item = $slider_list->fetch()) {
        ?>
        <div class="slider-item">
            <div class="overlay"></div>
            <div class="container-fluid px-md-0">
                <div class="row d-md-flex no-gutters slider-text align-items-end justify-content-end"
                    data-scrollax-parent="true">
                    <div class="one-third order-md-last img" style="background-image: url('images/upload/<?php echo $slider_item['v_main_image_url'] ?>');">
                        <div class="overlay"></div>
                        <div class="overlay-1"></div>
                    </div>
                    <div class="one-forth d-flex  align-items-center ftco-animate"
                        data-scrollax=" properties: { translateY: '70%' }">
                        <div class="text">
                            <h1 class="mb-4 mt-3"><?php echo $slider_item['v_post_title'] ?></h1>
                            <span class="subheading"><?php echo $slider_item['v_post_summary'] ?></span>
                            <p><a href="single.php?id=<?php echo $slider_item['n_blog_post_id']?>" class="btn btn-primary btn-primary">Xem bài viết này</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>