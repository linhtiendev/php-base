<!-- file chính -->
<?php
session_start(); // khởi tạo session
require_once('config.php'); // gọi file config
require_once('./includes/connect.php');

// thư viện phpmailer
require_once('./includes/phpmailer/Exception.php');
require_once('./includes/phpmailer/PHPMailer.php');
require_once('./includes/phpmailer/SMTP.php');

//nhúng cấu hình các hàm dùng chung
require_once('./includes/function.php');
require_once('./includes/database.php');
require_once('./includes/session.php');

// setFlashData('msg', 'finished');
// echo getFlashData('msg');

// $subjectEmail = 'Liti xin chao';
// $contentEmail = 'day la noi dung';
$subjectEmail =
    $contentEmail =
    sendMail('lelinhtien0707@gmail.com', $subjectEmail, $contentEmail);

$module = _MODULE;
$action = _ACTION;

// Hàm điều hướng modules
// dk lấy module
// check rỗng
if (!empty($_GET['module'])) {
    // check chuỗi
    if (is_string($_GET['module'])) {
        $module = trim($_GET['module']);
    }
}

// dk lấy action trong module
if (!empty($_GET['action'])) {
    if (is_string($_GET['action'])) {
        $action = trim($_GET['action']);
    }
}

// có được module và action rồi thì ghép lại thành path để điều hướng
$path = 'modules/' . $module . '/' . $action . '.php';

// kiểm tra file có tồn tại
if (file_exists($path)) {
    // dùng require để thực hiện điều hướng
    require_once($path);
} else {
    // sai path sẽ điều hướng sang error
    require_once 'modules/error/404.php';
}
