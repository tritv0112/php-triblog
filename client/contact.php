<?php
    include "admin/includes/database.php";
    include "admin/includes/contacts.php";
    include "admin/includes/tags.php";
    include "admin/includes/blogs.php";

    $database = new Database();
    $db = $database->connect();

    $contact = new Contact($db);
    $tag = new Tag($db);      
    $blog = new Blog($db);
    $blog_list = $blog->read();

    if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['email'])!=""){
            $subscriber = new Subscriber($db);
            $subscriber->v_sub_email = $_POST['email'];
            $subscriber->d_date_created = date('y-m-d',time());
            $subscriber->d_time_created = date('h:i:s',time());
            $subscriber->f_sub_status = 1;
            $subscriber->create();       
        }

        if(isset($_POST['submit_contact'])){
            $contact->v_fullname = $_POST['c_name'];
            $contact->v_email = $_POST['c_email'];
            $contact->v_phone = $_POST['c_phone'];        
            $contact->v_message = $_POST['c_message'];
            $contact->d_date_created = date('y-m-d',time());
            $contact->d_time_created = date('h:i:s',time());
            $contact->f_contact_status = 1;
            $contact->create();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'meta.php'; ?>
    <?php include 'style.php'; ?>
    <title>HoaBlog - Liên hệ</title>

</head>

<body>

    <?php include 'navbar.php'; ?>

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread">Liên hệ</h1>
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="index.php">Trang chủ
                                <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </span> 
                        <span>Liên hệ
                            <i class="ion-ios-arrow-forward"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section contact-section bg-light">
        <div class="container">
            <div class="row d-flex mb-5 contact-info">
                <div class="col-md-12 mb-4">
                    <h2 class="h4">Thông tin liên hệ</h2>
                </div>
                <div class="w-100"></div>
                <div class="col-md-3">
                    <b>Địa chỉ:</b>
                    <p>171B Hoàng Hoa Thám, Phường 13, Quận Tân Bình, Thành phố Hồ Chí Minh</p>
                </div>
                <div class="col-md-3">
                    <b>Số điện thoại:</b>
                    <p><a href="tel://02837256347">028 3725 6347</a></p>
                </div>
                <div class="col-md-3">
                    <b>Email:</b>
                    <p><a href="mailto:tuyendung@transcosmos.com">tuyendung@transcosmos.com</a></p>
                </div>
                <div class="col-md-3">
                    <b>Website:</b>
                    <p><a href="trans-cosmos.com.vn">trans-cosmos.com.vn</a></p>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-no-pt ftco-no-pb contact-section">
        <div class="container-wrap">
            <div class="row d-flex align-items-stretch no-gutters">
                <div class="col-md-6 p-5 order-md-last">
                    <h2>Hãy nêu cảm nhận của bạn về trang này</h2>
                    <p>Những lời góp ý chân thành của bạn sẽ là bàn đạp vững chắc để chúng tôi cải thiện sản phẩm này.</p>
                    <form action="#">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Nhập tên của bạn">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Nhập email của bạn">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Nhập tiêu đề">
                        </div>
                        <div class="form-group">
                            <textarea name="" id="" cols="30" rows="7" class="form-control"
                                placeholder="Nhập nội dung góp ý"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Gửi" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>
                </div>
                <div class="col-md-6 d-flex align-items-stretch">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <?php include 'script.php'; ?>
    
</body>

</html>