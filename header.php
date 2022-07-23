<?php 
    session_start();

    include "admin/includes/database.php";
    include "admin/includes/categories.php";
    include "admin/includes/blogs.php";
    include "admin/includes/tags.php";
    include "admin/includes/comments.php";
    include "admin/includes/contacts.php";
    include "admin/includes/subscribers.php";

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);
    $blog = new Blog($db);
    $comment = new Comment($db);
    $tag = new Tag($db);
    $contact = new Contact($db);

    if (empty($_SESSION['session_id'])) {
        $_SESSION['session_id'] = session_id();
        $sum = (int)file_get_contents('admin/counter.txt') + 1;
        file_put_contents('admin/counter.txt', $sum);
    }

    function redirect() {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['submit_subscribe']) != ''){
            $subscriber = new Subscriber($db);
            $subscriber->v_sub_email = $_POST['email'];
            $subscriber->d_date_created = date('y-m-d',time());
            $subscriber->d_time_created = date('h:i:s',time());
            $subscriber->f_sub_status = 1;
            if ($subscriber->create()) {
                redirect();
            }
        }
    }
?>