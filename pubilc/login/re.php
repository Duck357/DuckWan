<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户中心</title>
    <style>
        .per {
            text-decoration: underline;
            transition: all 0.3s ease; /* 这里定义了过渡效果 */
        }
        .per:hover{
            color: blue;
            font-size: 30px;
        }
    </style>
</head>
<body>
    <?php
    $codearray = json_decode(file_get_contents("code"),true);
    $error = 0;
    $aaa = true;
    
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
    $error = 0;
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
        $error = 0;
        $color = $_POST['color'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $image = $_POST['image'];
        $info = $_POST['info'];
        $code = $_POST['code'];
    
        // 防止 SQL 注入
        $name = $conn->real_escape_string($name);
        $password = $conn->real_escape_string($password);
        $image = $conn->real_escape_string($image);
        $info = $conn->real_escape_string($info);
        $code = $conn->real_escape_string($code);
        $color = $conn->real_escape_string($color);
        $per = 3;
        $g = 0;
        if($code == "LDW1" || $code == "LDW2") $g = 15;
        $json = '{"time": "'.date('Y.m.d').'","coin": {"gold": '.$g.'},"pages": []}';
        if($name != '' && $image != '' && $info != '' && strlen($info) <= 100){
            if(isset($password)){
                if (!array_key_exists($code, $codearray)) {
                    $error = 1; // 设置错误代码
                } else {
                    // 使用预处理语句添加新用户
                    $stmt = $conn->prepare("SELECT name, password, image, info FROM user WHERE name = ? AND password = ?");
                    $stmt->bind_param("ss", $name, $password); // 这里只需要两个参数
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $error = 2;
                        } else {
                            // 插入新用户
                            $insertStmt = $conn->prepare("INSERT INTO user (name, password, image, info, per, color, json) VALUES (?, ?, ?, ?, ?, ?, ?)");
                            $insertStmt->bind_param("ssssiss", $name, $password, $image, $info, $per, $color, $json);
                            if ($insertStmt->execute()) {
                                $aaa = false;
                                unset($codearray[$code]);
                                echo "<center><h1>普通用户 ".$name." 注册成功!</h1>";
                                echo "<h1>请记住您的密码 ".$password."</h1>";
                                echo "<h1>返回 <a href='index.php'>登录页面</a></h1></center>";
                                file_put_contents("code",json_encode($codearray));
                            } else {
                                echo "Error: 111";
                            }
                            $insertStmt->close();
                        }
                    } else {
                        echo "Error: 222";
                    }
                    $stmt->close();
                }
            }else{
                $error = 3;
            }
        }else{
            $error = 2;
        }
    }
    
    // 关闭连接
    $conn->close();
    
    
    ?>
    
    <center>
        <?php if ($aaa): ?>
        <h1 style="font-size: 30px;">DuckWan帐号注册</h1>
        <form action="" method="POST">
            <h2>用户名(不可重复)</h2>
            <input type="text" name="name">
            <h2>头像(只能输入一个字符,多一个都不行)</h2>
            <input type="text" name="image" maxlength="2"><br>
            <label>头像背景颜色</label>
            <input type="color" name="color">
            <h2>密码</h2>
            <input type="password" name="password">
            <h2>简介</h2>
            <textarea type="text" name="info" maxlength="100"></textarea>
            <h2>注册码</h2>
            <h3>前往<a href="/buy/index.php">购买</a>,或者联系我wx获取(不收费)</h3>
            <input type="text" name="code">
            <br>
            <input type="submit" value="提交" name="submit">
        </form>
        <h2>有帐号?<a href="index.php">登录</a></h2>
        <?php endif; ?>
        <?php if ($error == 1): ?>
        <h2 style="color:red;">注册码错误!</h2>
        <?php endif; ?>
        <?php if ($error == 2): ?>
        <h2 style="color:red;">用户名不合法<br>重名或为空白</h2>
        <?php endif; ?>
        <?php if ($error == 3): ?>
        <h2 style="color:red;">密码输入不合法</h2>
        <?php endif; ?>
    </center>
</body>
</html>