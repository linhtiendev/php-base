<!-- chứa function dùng chung  -->
<?php
//  defined() kiểm tra hàm số có tồn tại hay không
// !defined() kiểm tra có không tồn tại hay không
if (!defined('_CODE')) {
    // truy cập kh hợp lệ sẽ dừng điều hướng truy cập
    die('Access denied...');
};

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// tạo biến layout để truyền layout và title
function layouts($layoutName = 'header', $dataPageTitle = [])
{
    if (file_exists(_WEB_PATH_TEMPLATES . '/layout/' . $layoutName . '.php')) {
        require_once _WEB_PATH_TEMPLATES . '/layout/' . $layoutName . '.php';
    }
}

// hàm xử lý truyền file css
function addCss($cssFiles = [])
{
    // Kiểm tra nếu $cssFiles là một chuỗi và chuyển nó thành mảng
    if (is_string($cssFiles)) {
        $cssFiles = [$cssFiles];
    }
    // Kiểm tra nếu $cssFiles là một mảng không rỗng
    if (!empty($cssFiles)) {
        foreach ($cssFiles as $cssFile) {
            // Kiểm tra nếu $cssFile là chuỗi và không rỗng
            if (is_string($cssFile) && !empty($cssFile)) {
                echo '<link rel="stylesheet" href="' . _WEB_HOST_TEMPLATES . '/css/' . $cssFile . '.css">';
            }
        }
    }
}

// hàm gửi mail
function sendMail($to, $subject, $content)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        // dùng email được tạo mật khẩu ứng dụng ở đây
        $mail->Username   = 'lelinhtien102@gmail.com';                     //SMTP username
        $mail->Password   = 'sqtxbdvmqqrkeyxd';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('lelinhtien0707@gmail.com', 'Linh Tien'); // email người nhận
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->CharSet = "UTF-8";
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;

        // PHP mailer SSL certificate verify failed
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $sendMail = $mail->send();
        if ($sendMail) {
            return $sendMail;
        }
        // echo 'Gửi thành công';
    } catch (Exception $e) {
        echo "Gửi mail không thành công. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Kiểm tra phương thức GET
function isGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

// Kiểm tra phương thức POST
function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

// hàm filter lọc dữ liệu
function filter()
{
    $filterArr = [];
    if (isGet()) {
        // xử lí dữ liệu trước khi hiển thị
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                // lọc trường hợp value là một mảng
                $key = strip_tags($key); //Loại bỏ thẻ HTML trong key bằng strip_tags()
                if (is_array($value)) {
                    //  filter_input() với FILTER_SANITIZE_SPECIAL_CHARS để lọc ký tự đặc biệt, bảo vệ khỏi XSS.
                    // Nếu giá trị là một mảng, sử dụng FILTER_REQUIRE_ARRAY để xử lý tất cả các phần tử.
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                // mã hóa dữ liệu đầu vào
            }
        }
    }

    if (isPost()) {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                // mã hóa dữ liệu đầu vào

            }
        }
    }
    return $filterArr;
}

// hàm kiểm tra email
function isEmail($email)
{
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}

// hàm kiểm tra số nguyên
function isNumberInt($number)
{
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    return $checkNumber;
}

// hàm kiểm tra số thực
function isNumberFloat($number)
{
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    return $checkNumber;
}

// hàm kiểm tra số điện thoại
function isPhone($phone)
{
    // kiểm tra số đầu có phải là số 0
    $checkZero = false;
    // ký tự đầu tiên là số 0
    if ($phone[0] == '0') {
        $checkZero = true;
        // xóa phần tử đầu tiên
        $phone = substr($phone, 1);
    }
    // kiểm tra sau số 0 có đủ 9 số
    $checkNumber = false;
    // kiểm tra số nguyên và lượng
    if (isNumberInt($phone) && (strlen($phone) == 9)) {
        $checkNumber = true;
    }
    // trả ra nếu 2 điều kiện trên hợp lệ
    if ($checkZero && $checkNumber) {
        return true;
    }
    return false;
}

// hàm thông báo smg lỗi
function getSmg($smg, $type = 'success')
{
    echo '<div class="alert alert-' . $type . ' mx-1">';
    echo $smg;
    echo '</div>';
}

// hàm điều hướng
function redirect($path = 'index.php')
{
    header("Location: $path");
    exit;
}

// hàm thông báo lỗi
function form_error($fileName, $beforeHtml = '', $afterHtml = '', $errors)
{
    return (!empty($errors[$fileName])) ? '<span class="error">' . reset($errors[$fileName]) . '</span>' : null;
}

// hàm hiển thị dl cũ khi nhập trong input
function oldData($fileName, $old_data = '', $default = null)
{
    return (!empty($old_data[$fileName])) ? $old_data[$fileName] : $default;
}

// Hàm kiểm tra trạng thái đăng nhập
function isLogin()
{
    $checkLogin = false;
    // lấy logintoken từ session
    if (getSession('logintoken')) {
        $tokenLogin = getSession('logintoken');

        // kiểm tra token có tồn tại với db
        $queryToken = oneRaw("SELECT user_id FROM logintoken WHERE token = '$tokenLogin'");

        if (!empty($queryToken)) {
            $checkLogin = true;
        } else {
            removeSession('logintoken');
        }
    }
    return $checkLogin;
}
