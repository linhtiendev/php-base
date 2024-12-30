<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

$dataPageTitle = [
    'pageTitle' => 'Đăng nhập tài khoản'
];

layouts('header', $dataPageTitle);

// Thêm file CSS cho login
addCss('auth/login');

// $check = isNumberInt(2);
// $check = isNumberFloat(2.2);
// var_dump($check);

$password = '123456';

// hàm mã hóa mật khẩu
// PASSWORD_DEFAULT: mã hóa mặc định bcrypt
$hashPassword = password_hash($password, PASSWORD_DEFAULT);
// So sánh mật khẩu đã nhập '123456' với chuỗi băm $hashPassword bằng password_verify.
$checkPass = password_verify('123456', $hashPassword);
var_dump($checkPass)

?>

<div class="row">
    <div class="col-6" style="margin: 50px auto;">
        <h2 class="text-center">Đăng Nhập</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="title" class="form__label">Email</label>
                <input name="email" type="email" class="form-control form__input" placeholder="Nhập email" />
            </div>
            <div class="form-group">
                <label for="" class="form__label">Password</label>
                <input name="password" type="password" class="form-control form__input" placeholder="Nhập mật khẩu" />
            </div>
            <button type="submit" class="primary_btn_custom submit__btn btn btn-primary btn-block">Đăng nhập</button>
            <hr />
            <div class="d-flex justify-content-between">
                <p class="text-center"><a href="?module=auth&action=register" class="text-dark text-decoration-none">Đăng ký</a></p>
                <p class="text-center"><a href="?module=auth&action=forgot_password" class="text-dark text-decoration-none">Quên mật khẩu</a></p>
            </div>
        </form>
    </div>
</div>

<?php
layouts('footer');
?>