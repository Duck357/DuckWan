<?php

session_start();
if(isset($_SESSION['loggedin'])){
if($_SESSION['root'] == 0){

// 检查是否有数据被提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 初始化错误消息变量
    $error = "无错误";
    $id = isset($_POST['id']) ? (int)$_POST['id'] : ''; // 将ID转换为整数
    $read = isset($_POST['read']) ? (int)$_POST['read'] : ''; // 将阅读量转换为整数

    // 检查ID和阅读量是否有效
    if ($id <= 0 || $read < 0) {
        $error = "无效的ID或阅读量";
    }else{
        $data = json_decode(file_get_contents('./json'),true);
        $data[$id]['read'] = $read;
        file_put_contents('./json',json_encode($data,JSON_UNESCAPED_UNICODE));
    }

    header('Location: root.php');
    exit();
}
}
}
?>