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
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;

        $mail->send();
        echo 'Gửi thành công';
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
