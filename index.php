<!-- file chính -->
<?php
// khởi tạo session
session_start();
// gọi file config
require_once('config.php');

// kiểm tra biến code trong từng thư mục
// echo _CODE; // kiểm tra có chạy đúng đường dẫn

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
