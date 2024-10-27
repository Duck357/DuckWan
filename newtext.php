<?php
// 检查是否有数据被提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 初始化错误消息变量
    $error = "无错误";

    // 获取表单数据
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // 检查密码是否正确
    if ($password === 12345) {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $info = isset($_POST['info']) ? $_POST['info'] : '';
        $text = isset($_POST['text']) ? $_POST['text'] : '';
        
        $data = json_decode(file_get_contents('text'),true);
        $data['name'] = $name;
        $data['info'] = $info;
        $data['text'] = $text;
        $data['time'] = date('Y-m-d H:i:s');
        file_put_contents('text',json_encode($data,JSON_UNESCAPED_UNICODE));
    } else {
        $error = "密码错误";
    }

    // 输出结果
    echo "状态: " . htmlspecialchars($error) . "<br>";
    echo "<a href='root.php'>返回后台</a><br>";
    echo "<a href='index.php'>返回网站</a>";
}
?>