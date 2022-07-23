<?php 
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['submit_contact'])){
            $contact->v_fullname = $_POST['c_name'];
            $contact->v_email = $_POST['c_email'];
            $contact->v_phone = $_POST['c_phone'];        
            $contact->v_message = $_POST['c_message'];
            $contact->d_date_created = date('y-m-d',time());
            $contact->d_time_created = date('h:i:s',time());
            $contact->f_contact_status = 1;
            if ($contact->create()) {
                header('Location: contact.php');
            }
        }
    }
?>

<section class="ftco-section contact-section ftco-no-pb" id="contact-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <span class="subheading"></span>
                <h2 class="mb-4">Hãy đánh giá chúng tôi</h2>
                <p>Thông tin của bạn sẽ được bảo mật.</p>
            </div>
        </div>

        <div class="row block-9">
            <div class="col-md-8">
                <form action="#" method="post" class="bg-light p-4 p-md-5 contact-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="c_name" class="form-control" placeholder="Nhập tên của bạn">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="c_phone" class="form-control" placeholder="Nhập số điện thoại của bạn">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="c_email" class="form-control" placeholder="Nhập email của bạn">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="c_message" id="" cols="30" rows="7" class="form-control"
                                    placeholder="Nhập nội dung"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" name="submit_contact" value="Gửi đánh giá" class="btn btn-primary py-3 px-5">
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <div class="col-md-4 d-flex pl-md-5">
                <div class="row">
                    <div class="dbox w-100 d-flex">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-map-marker"></span>
                        </div>
                        <div class="text">
                            <p><span>Địa chỉ:</span> 198 Hoàng Sa, Phường 6, Quận 3</p>
                        </div>
                    </div>
                    <div class="dbox w-100 d-flex">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-phone"></span>
                        </div>
                        <div class="text">
                            <p><span>Số điện thoại:</span> </p>
                        </div>
                    </div>
                    <div class="dbox w-100 d-flex">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-paper-plane"></span>
                        </div>
                        <div class="text">
                            <p><span>Email:</span> <a href="mailto:20661040@kthcm.edu.vn">20661040@kthcm.edu.vn</a></p>
                        </div>
                    </div>
                    <div class="dbox w-100 d-flex">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-globe"></span>
                        </div>
                        <div class="text">
                            <p><span>Website</span> <a href="#">triblog.herokuapp.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>