<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户中心</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
          }
          .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 20px 0;
            width: 200px;
            background: #333;
          }
          .sidebar .nav {
            flex-direction: column;
          }
          .sidebar .nav-link {
            color: #fff;
            padding: 10px 20px;
            border-radius: 0;
          }
          .sidebar .nav-link:hover,
          .sidebar .nav-link.active {
            background: #555;
          }
          .nav {
              display: flex;
              flex-direction: column;
          }
          .nav-link {
              text-decoration: none;
          }
          .main-content {
            margin-left: 200px;
            padding: 20px;
          }
          .header {
            padding: 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #e7e7e7;
          }
          .tab-content {
            margin-top: 20px;
          }
          .tab-pane {
            display: none;
          }
          .tab-pane.active {
            display: block;
          }
        .per {
            text-decoration: underline;
            transition: all 0.3s ease; /* 这里定义了过渡效果 */
        }
        .per:hover{
            color: blue;
            font-size: 30px;
        }
        .pages {
            background-color: #d6eceb;
            margin-left: 100px;
            margin-right: 100px;
            min-height: 300px;
            margin: 30px;
            border-radius: 20px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            flex-wrap: wrap;
            overflow-y: auto;
        }
        .page {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            background-color: #636363;
            box-shadow: -4px -4px 0px black;
            transition: all 0.3s ease;
            width: 90%;
            height: 100px;
            border-radius: 6px;
            margin-top: 20px;
            color: aliceblue;
            overflow-y: auto;
        }
        .page h1 , .page h2{
            overflow-x: auto;
            width: 250px;
            height: 30px;
            margin: 2px;
        }
        .page:hover {
            box-shadow: 0px 0px 0px black;
            transform: translate(-4px,-4px);
        }
    </style>
</head>
<body>
    <?php
    session_start();
    
    if(isset($_SESSION['loggedin'])){
        $a = "游客用户";
        if($_SESSION['root'] == 0){
            $a = "管理员";
        }else if($_SESSION['root'] == 1){
            $a = "高级用户";
        }else if($_SESSION['root'] == 2){
            $a = "中级用户";
        }else if($_SESSION['root'] == 3){
            $a = "普通用户";
        }else if($_SESSION['root'] == 4){
            $a = "捐赠者";
        }
    }else{
        $servername = "";
        $username = "";
        $password = "";
        $dbname = "";
        
        // 创建连接
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // 检查连接
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];
        
            // 防止 SQL 注入
            $name = $conn->real_escape_string($name);
            $password = $conn->real_escape_string($password);
        
            // 使用预处理语句
            $stmt = $conn->prepare("SELECT id, name, password, image, info, per, color, json FROM user WHERE name = ? AND password = ?");
            $stmt->bind_param("ss", $name, $password); // "ss" 表示两个参数都是字符串类型
        
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // 设置会话变量
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['username'] = $row["name"];
                    $_SESSION['password'] = $row["password"];
                    $_SESSION['root'] = $row['per'];
                    $_SESSION['img'] = $row['image'];
                    $_SESSION['info'] = $row['info'];
                    $_SESSION['color'] = $row['color'];
                    $_SESSION['json'] = json_decode($row['json'] , true);
                    $a = "游客用户";
                    if($_SESSION['root'] == 0){
                        $a = "管理员";
                    }else if($_SESSION['root'] == 1){
                        $a = "高级用户";
                    }else if($_SESSION['root'] == 2){
                        $a = "中级用户";
                    }else if($_SESSION['root'] == 3){
                        $a = "普通用户";
                    }else if($_SESSION['root'] == 4){
                        $a = "捐赠者";
                    }
                }
            } else {
                echo "登录失败：用户名或密码错误";
            }
        
            $stmt->close();
        }
        // 关闭连接
        $conn->close();
    }
    ?>
    
    <?php if (isset($_SESSION['loggedin'])): ?>
        <div class="sidebar">
        <nav class="nav">
            <a class="nav-link active" href="#dashboard" data-toggle="tab">仪表板</a>
            <a class="nav-link" href="#orders" data-toggle="tab">文章管理</a>
            <a class="nav-link" href="#users" data-toggle="tab">信息修改</a>
            <a class="nav-link" href="#settings" data-toggle="tab">设置</a>
        </nav>
        </div>
        <div class="main-content">
            <div class="header">
                <h2>用户主页</h2></div>
            <div class="tab-content">
                <div class="tab-pane active" id="dashboard">
                    <h3>仪表盘</h3>
                    <p>欢迎来到个人用户管理系统。</p>
                    <?php
                    echo '<div style="font-size: 150px;background-color: '.$_SESSION['color'].';width: 200px;height: 200px;border-radius: 10px;margin: 20px;text-align: center;">' . $_SESSION['img'] . '</div>';
                    echo '<h2 style="font-size: 20px;margin: 20px;">' . $_SESSION['info'] . '</h2>';
                    echo "<h2>欢迎回来 <strong class='per'>" . $a . " </strong>" . $_SESSION['username']. " :)</h2><h3>你在".$_SESSION['json']['time']."加入了DuckWan论坛<br>".$_SESSION['json']['coin']['gold']."积分</h3><br><h2><a href='logout.php'>退出登录</a></h2>
        <p><a href='https://duckwan.link'>前往网站</a></p>";
                    ?>
                </div>
                <div class="tab-pane" id="orders">
                    <h3>文章管理</h3>
                    <p>这里是文章管理的内容。</p>
                    <?php
                    echo "<div class='pages'>";
                    foreach (json_decode(file_get_contents('../json'),true) as $page){
                        if(isset($page['uid'])){
                            if($page['uid'] == $_SESSION['id']){
                                echo '<div class="page">
                                <h1 style="font-size: 20px;">'.$page['title'].'</h1>
                                <h2 style="font-size: 20px">'.$page['time'].'</h2>
                                <h2 style="font-size: 20px">'.$page['read'].'阅读</h2>
                                </div>
                                ';
                            }
                        }
                    }
                    echo "</div>";
                    ?>
                </div>
                <div class="tab-pane" id="users">
                    <h3>信息修改</h3>
                    <p>这里是用户信息修改的地方。</p>
                    <form action="new.php" method="post">
                        <label for="username">修改用户名:</label>
                        <input type="text" id="username" name="username" placeholder="<?php
                        echo $_SESSION['username'];
                        ?>" value="<?php
                        echo $_SESSION['username'];
                        ?>"><br><br>
                        <label for="image">修改头像:</label>
                        <input maxlength="1" type="text" id="image" name="image" placeholder="<?php
                        echo $_SESSION['img'];
                        ?>" value="<?php
                        echo $_SESSION['img'];
                        ?>"><br><br>
                        <label for="color">修改背景:</label>
                        <input type="color" id="color" name="color"><br><br>
                        
                        <label for="password">修改密码:</label>
                        <input type="text" id="password" name="password" value="<?php
                        echo $_SESSION['password'];
                        ?>"><br><br>
                        
                        <label for="info">修改简介:</label><br>
                        <textarea rows=5 type="text" id="info" name="info" value="<?php
                        echo $_SESSION['info'];
                        ?>"></textarea><br><br>
                        
                        <button type="submit">完成</button>
                    </form>
                    <?php
                    
                    ?>
                </div>
                <div class="tab-pane" id="settings">
                    <h3>设置</h3>
                    <p>这里是设置的内容。</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
    <center>
        <form action="" method="post">
            <h3>用户名:<input type="text" name="name"></h3>
            <h3>密码:<input type="password" name="password"></h3>
            <h2><input type="submit" name="submit" value="登录"></h2>
        </form>
        <h2>没有帐号?<a href="re.php">注册</a></h2>
        <p><a href="https://duckwan.link">前往网站</a></p>
    </center>
    <?php endif; ?>
        
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
      $(document).ready(function() {
        $('.nav-link').click(function(e) {
          e.preventDefault();
          $('.nav-link').removeClass('active');
          $(this).addClass('active');
          var href = $(this).attr('href');
          $(href).addClass('active').siblings('.tab-pane').removeClass('active');
        });
      });
    </script>
</body>
</html>