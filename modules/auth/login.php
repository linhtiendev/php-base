<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

layouts('header');

// Thêm file CSS cho login
addCss('auth/login')
?>

<div class="row">
    <div class="col-6" style="margin: 50px auto;">
        <h2 class="text-center">Đăng Nhập</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="title" class="form__label">Email</label>
                <input type="email" class="form-control form__input" placeholder="Nhập email" />
            </div>
            <div class="form-group">
                <label for="title" class="form__label">Password</label>
                <input type="password" class="form-control form__input" placeholder="Nhập mật khẩu" />
            </div>
            <button type="submit" class="primary_btn_custom submit__btn btn btn-primary btn-block">Đăng nhập</button>
            <hr />
            <div class="d-flex justify-content-between">
                <p class="text-center"><a href="?module=auth&action=register" class="text-dark text-decoration-none">Đăng kí</a></p>
                <p class="text-center"><a href="?module=auth&action=forgot_password" class="text-dark text-decoration-none">Quên mật khẩu</a></p>
            </div>
        </form>
    </div>
</div>

<?php
layouts('footer');
?>