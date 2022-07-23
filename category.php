<?php
    $count = 1;
    $result = $category->read();
?>

<section class="ftco-section ftco-project" id="category-section">
    <div class="container-fluid px-md-4">
        <div class="row justify-content-center pb-5">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="mb-4">Danh mục</h2>
            </div>
        </div>
        <div class="row">
            <?php 
                while($rows = $result->fetch()) { 
                    $blog->n_category_id = $rows['n_category_id'];
                    $blog_result = $blog->read_blog_by_category();
                    if ($blog_result->rowCount() > 0) {
                        if ($count > 8) {
                            $count = 1;
                        }
            ?>
            <div class="col-md-3">
                <a href="cate_search.php?id=<?php echo $rows['n_category_id']; ?>">
                    <div class="project img shadow ftco-animate d-flex justify-content-center align-items-center"
                        style="background-image: url(images/work-<?php echo $count ?>.jpg);">
                        <div class="overlay"></div>
                        <div class="text text-center p-4">
                            <h3 class="text-white"><?php echo $rows['v_category_title']; ?></h3>
                        </div>
                    </div>
                </a>
            </div>
            <?php 
                        $count++;
                    }
                } 
            ?>
        </div>
    </div>
</section>