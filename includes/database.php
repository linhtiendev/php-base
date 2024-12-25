<!-- chứa hàm liên quan đến xử lý db -->
<?php
if (!defined('_CODE')) {
    die('Access denied...');
};

// hàm query thao tác trực tiếp với db
function query($sql, $data = [])
{
    global $conn;
    $result = false;
    try {
        // Chuẩn bị sẵn một câu truy vấn SQL để có thể thực thi một cách an toàn
        $statement = $conn->prepare($sql);

        if (!empty($data)) {
            $result = $statement->execute($data);
        } else {
            $result = $statement->execute();
        }
    } catch (Exception $exp) {
        echo $exp->getMessage() . '<br >';
        echo 'File: ' . $exp->getFile() . '<br >';
        echo 'Line: ' . $exp->getLine();
        die();
    }
    return $result;
}
