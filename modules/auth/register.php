<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

$dataPageTitle = [
    'pageTitle' => 'Đăng ký tài khoản'
];

layouts('header', $dataPageTitle);

// Thêm file CSS cho login
addCss('auth/login')
?>

<div class="row">
    <div class="col-6" style="margin: 50px auto;">
        <h2 class="text-center text-uppercase">Đăng Ký</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="title" class="form__label">Họ và Tên</label>
                <input type="fullname" class="form-control form__input" placeholder="Nhập họ và tên" />
            </div>
            <div class="form-group">
                <label for="title" class="form__label">Email</label>
                <input type="email" class="form-control form__input" placeholder="Nhập email" />
            </div>
            <div class="form-group">
                <label for="title" class="form__label">Số điện thoại</label>
                <input type="number" class="form-control form__input" placeholder="Nhập số điện thoại" />
            </div>
            <div class="form-group">
                <label for="title" class="form__label">Password</label>
                <input type="password" class="form-control form__input" placeholder="Nhập mật khẩu" />
            </div>
            <div class="form-group">
                <label for="title" class="form__label">Password</label>
                <input type="password" class="form-control form__input" placeholder="Nhập lại mật khẩu" />
            </div>
            <div class="d-flex">
                <button type="submit" class="primary_btn_custom submit__btn btn btn-primary btn-block">Đăng Ký</button>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <p class="text-center">Bạn đã có tài khoản?</p>
                <p class="text-center"><a href="?module=auth&action=login" class="text-dark text-decoration-none">Đăng nhập</a></p>
            </div>
        </form>
    </div>
</div>

<?php
layouts('footer');
?>