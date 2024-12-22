<?php
session_start();
// 检查是否有数据被提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $ausername = $_POST['username'];
    $uimg = $_POST['image'];
    $ucolor = $_POST['color'];
    $upassword = $_POST['password'];
    $uinfo = $_POST['info'];

    // 这里可以添加数据验证和处理的代码
    // 例如，检查用户名和邮箱是否为空，密码是否符合要求等

    // 假设数据验证通过，你可以将数据保存到数据库或进行其他处理
    // 这里只是一个示例，所以只是输出接收到的数据
    echo "用户名: " . htmlspecialchars($ausername) . "<br>";
    echo "头像: " . htmlspecialchars($uimg) . "<br>";
    echo "密码: " . htmlspecialchars($upassword) . "<br>";
    
    // 数据库配置信息
    $servername = ""; // 数据库服务器地址
    $username = ""; // 数据库用户名
    $password = ""; // 数据库密码
    $dbname = ""; // 数据库名称
    
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // 检查连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    
    // 要更新的用户信息
    $id = $_SESSION['id']; // 假设我们要更新id为1的用户
    $newUsername = $ausername;
    $newpass = $upassword;
    
    // 检查用户名是否已存在
    $checkStmt = $conn->prepare("SELECT * FROM `user` WHERE `name` = ?");
    $checkStmt->bind_param("s", $newUsername);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    // 如果用户名已存在，则不进行更新
    if ($result->num_rows > 0 && $ausername != $_SESSION['username']) {
        echo "用户名已存在，不进行修改。";
    } else {
    
        // 准备SQL语句
        $stmt = $conn->prepare("UPDATE `user` SET `name` = ?, `password` = ?, `image` = ?, `info` = ?, `color` = ? WHERE `user`.`id` = ?");
        $stmt->bind_param("sssssi", $newUsername, $newpass,$uimg,$uinfo,$ucolor, $id); // "ssi"代表绑定的参数类型，分别是字符串、字符串、整型
        
        // 执行语句
        if ($stmt->execute()) {
            echo "更新成功";
            $_SESSION['img'] = $uimg;
            $_SESSION['color'] = $ucolor;
            $_SESSION['username'] = $ausername;
            $_SESSION['password'] = $newpass;
            $_SESSION['info'] = $uinfo;
        } else {
            echo "更新失败: ";
        }
    }
    echo "<button onclick='window.location.href = \"index.php\"'>返回</button>";
    // 关闭语句和连接
    $stmt->close();
    $conn->close();
} else {
    // 如果不是POST请求，可以重定向回表单页面或显示错误信息
    echo "无效的请求";
}
?>