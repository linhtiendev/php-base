<?php
if (!defined('_CODE')) {
    die('Access denied...');
};
$dataPageTitle = ['pageTitle' => 'Dashboard'];
layouts('header', $dataPageTitle);
require_once(_WEB_PATH_TEMPLATES . '/layout/header.php');

// kiểm tra trang thái đăng nhập
// truy cập không hợp lệ sẽ điều hướng về trang login
if (!isLogin()) {
    redirect('?module=auth&action=login');
}
?>

<h1>dashboard</h1>

<?php
require_once(_WEB_PATH_TEMPLATES .  '/layout/footer.php');
?>