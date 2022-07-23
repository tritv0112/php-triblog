<?php 
    include "admin/includes/categories.php";
    $category = new Category($db);
    $category_list = $category->read();
?>

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php">HoaBlog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
            aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="index.php" class="nav-link">Trang chủ</a></li>
                <li class="nav-item has-children">
                    <a href="#" class="nav-link">Chuyên mục</a>
                    <ul class="sub-menu">
                        <?php while ($category_item = $category_list->fetch()): ?>
                        <li><a href="categories.php?id=<?php echo $category_item['n_category_id']; ?>">
                            <?php echo $category_item['v_category_title']; ?>
                        </a></li>
                        <?php 
                            if (isset($_GET['id']) && $category_item['n_category_id'] == $_GET['id']):
                                $current_category_title = $category_item['v_category_title']; 
                            endif;
                        ?>
                        <?php endwhile; ?>
                    </ul>
                </li>
                <li class="nav-item"><a href="blogs.php" class="nav-link">Bài viết</a></li>
                <li class="nav-item"><a href="about.php" class="nav-link">Về chúng tôi</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Liên hệ</a></li>
                <li class="nav-item">
                    <form action="search.php" id="search-form" method="get">
                        <input type="text" class="search-field" placeholder="Tìm kiếm..." name="q" autocomplete="off">
                        <button type="submit" class="search-submit"><span class="icon-search"></span></button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- END nav -->