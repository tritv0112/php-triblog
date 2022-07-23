<?php  
    include "admin/includes/database.php";
    include "admin/includes/subscribers.php";
    include "admin/includes/blogs.php";
    include "admin/includes/tags.php";

    $database = new Database();
    $db = $database->connect();

    $tag = new tag($db);      
    $blog = new blog($db);
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
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <?php include 'meta.php'; ?>
    <?php include 'style.php'; ?>
    <title>HoaBlog - Về chúng tôi</title>
    
</head>

<body>

    <?php include 'navbar.php'; ?>    

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread">HoaBlog</h1>
                    <h4 class="mb-2 bread">Nơi kết nối cảm xúc của những trái tim băng giá</h4>
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="index.html">Trang chủ 
                                <i class="ion-ios-arrow-forward"></i>
                            </a>
                        </span> 
                        <span>Về chúng tôi 
                            <i class="ion-ios-arrow-forward"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-5 p-md-5 img img-2" style="background-image: url(images/bg_3.jpg);">
                </div>
                <div class="col-md-7 wrap-about pb-md-5 ftco-animate">
                    <div class="heading-section mb-5 pl-md-5">
                        <div class="pl-md-5 ml-md-5">
                            <span class="subheading subheading-with-line"><small
                                    class="pr-2 bg-white">About</small></span>
                            <h2 class="mb-4">We are the best Interior, Exterior &amp; Architecture Firm</h2>
                        </div>
                    </div>
                    <div class="pl-md-5 ml-md-5 mb-5">
                        <p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it
                            would have been rewritten a thousand times and everything that was left from its origin
                            would be the word "and" and the Little Blind Text should turn around and return to its own,
                            safe country. But nothing the copy said could convince her and so it didn’t take long until
                            a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged
                            her into their agency, where they abused her for their.</p>
                        <p>When she reached the first hills of the Italic Mountains, she had a last view back on the
                            skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of
                            her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she
                            continued her way.</p>
                        <p><a href="#" class="btn-custom">Learn More <span class="ion-ios-arrow-forward"></span></a></p>
                    </div>
                </div>
            </div>
            <div class="row mt-5 pt-4">
                <div class="col-md-4 ftco-animate">
                    <h3 class="h4">Sứ mệnh</h3>
                    <p>Mang đến cho bạn một không gian ấm áp, một nơi mà hàng triệu trái tim đang cô đơn có thể hòa nhịp cùng nhau.</p>
                </div>
                <div class="col-md-4 ftco-animate">
                    <h3 class="h4">Tầm nhìn</h3>
                    <p>Tầm nhìn xa trông rộng khoảng 331.690 km².</p>
                </div>
                <div class="col-md-4 ftco-animate">
                    <h3 class="h4">Tôi là ai</h3>
                    <p>Và đây là đâu...</p>
                </div>
            </div>
        </div>
    </section>


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
                                    <span>Years of Experienced</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18">
                                <div class="text">
                                    <strong class="number" data-number="351">0</strong>
                                    <span>Happy Clients</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18">
                                <div class="text">
                                    <strong class="number" data-number="564">0</strong>
                                    <span>Finished Projects</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18">
                                <div class="text">
                                    <strong class="number" data-number="300">0</strong>
                                    <span>Working Days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section testimony-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section ftco-animate">
                    <span class="subheading subheading-with-line"><small class="pr-2 bg-light">Testimony</small></span>
                    <h2 class="mb-4">Our satisfied customer says</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there
                        live the blind texts. Separated they live in</p>
                </div>
            </div>
            <div class="row ftco-animate">
                <div class="col-md-12">
                    <div class="carousel-testimony owl-carousel">
                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5" style="background-image: url(images/person_1.jpg)">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the
                                        countries Vokalia and Consonantia, there live the blind texts.</p>
                                    <div class="pl-5">
                                        <p class="name">Garreth Smith</p>
                                        <span class="position">CEO Founder of Commercial Building</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5" style="background-image: url(images/person_2.jpg)">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the
                                        countries Vokalia and Consonantia, there live the blind texts.</p>
                                    <div class="pl-5">
                                        <p class="name">Garreth Smith</p>
                                        <span class="position">CEO Founder of Interior Design</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5" style="background-image: url(images/person_3.jpg)">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the
                                        countries Vokalia and Consonantia, there live the blind texts.</p>
                                    <div class="pl-5">
                                        <p class="name">Garreth Smith</p>
                                        <span class="position">Exterior Designer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5" style="background-image: url(images/person_1.jpg)">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the
                                        countries Vokalia and Consonantia, there live the blind texts.</p>
                                    <div class="pl-5">
                                        <p class="name">Garreth Smith</p>
                                        <span class="position">Landscape Designer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5" style="background-image: url(images/person_1.jpg)">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the
                                        countries Vokalia and Consonantia, there live the blind texts.</p>
                                    <div class="pl-5">
                                        <p class="name">Garreth Smith</p>
                                        <span class="position">System Analyst</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    
    <?php include 'script.php'; ?>

</body>

</html>