<?php
// 检查是否有数据被提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 初始化错误消息变量
    $error = "无错误";

    // 获取表单数据
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // 检查密码是否正确
    if ($password === 12345) {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : ''; // 将ID转换为整数
        $read = isset($_POST['read']) ? (int)$_POST['read'] : ''; // 将阅读量转换为整数

        // 检查ID和阅读量是否有效
        if ($id <= 0 || $read < 0) {
            $error = "无效的ID或阅读量";
        }else{
            $data = json_decode(file_get_contents('json'),true);
            $data[$id]['read'] = $read;
            file_put_contents('json',json_encode($data,JSON_UNESCAPED_UNICODE));
        }
    } else {
        $error = "密码错误";
    }

    // 输出结果
    echo "状态: " . htmlspecialchars($error) . "<br>";
    echo "<a href='root.php'>返回后台</a><br>";
    echo "<a href='index.php'>返回网站</a>";
}
?>