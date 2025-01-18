<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://duckwan.link/image/icon.ico" />
    <title>发布帖子 - DuckWan论坛</title>
    <meta name="description" content="发布您的游戏帖子，分享经验和资源，帮助他人解决问题。">
    <!-- 引入外部CSS文件 -->
    <link rel="stylesheet" href="/web/home.css">
    <style>
        /* 通用样式 */
        body {
            background-color: #f4f4f4;
            color: #333;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* Header */
        header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo {
            font-size: 24px;
            font-weight: bold;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
        }

        header nav ul li {
            display: inline-block;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
        }

        /* Main Content */
        .main-content {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
        }

        .container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .container label {
            font-size: 16px;
            display: block;
            margin-bottom: 8px;
        }

        .container input[type='text'],
        .container textarea , .container input[type='file'] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            background-color: #f9f9f9;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .container input[type='text']:focus,
        .container textarea:focus,
        .container input[type='file']:focus {
            border-color: #007bff;
            outline: none;
        }

        .container textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .container #article {
            min-height: 200px;
        }

        .container input[type='submit'] {
            padding: 12px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        .container input[type='submit']:hover {
            background-color: #0056b3;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">DuckWan</div>
        <nav>
            <ul>
                <li><a href="https://DuckWan.link/">首页</a></li>
                <li><a href="/add/">发布帖子</a></li>
                <li><a href="/box/">公告</a></li>
                <?php
                if (isset($_SESSION['loggedin'])) {
                    echo '<li><a href="/login/">' . $_SESSION['username'] . '</a></li><li><a href="/login/logout.php">退出登录</a></li>';
                } else {
                    echo '<li><a href="/login/">登录</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h2>发布新帖子</h2>
            <form action="get.php" method="post" enctype="multipart/form-data" onsubmit="disableSubmitButton()" accept-charset="UTF-8">
                <label for="name">文章名称</label>
                <input type="text" id="name" name="name" placeholder="文章名称" maxlength="40" required>
    
                <label for="author">作者代称</label>
                <input type="text" id="author" name="author" <?php
                    if (isset($_SESSION['loggedin'])) echo "value='" . $_SESSION['username'] . "' disabled='disabled'";
                    ?> maxlength="20" required>
    
                <label for="code">文章发布码</label>
                <input type="text" id="code" name="code" placeholder="文章发布码" maxlength="20" required <?php
                    if (isset($_SESSION['loggedin'])) echo "value='IDUCK667788' disabled='disabled'";
                    ?>>
    
                <label for="link">跳转链接（选填）</label>
                <input type="text" id="link" name="link" placeholder="跳转链接(选填)" maxlength="100">
    
                <label for="info">简介</label>
                <textarea id="info" name="info" placeholder="简介" required maxlength="200" rows="3"></textarea>
    
                <label for="article">文章</label>
                <textarea id="article" name="article" placeholder="文章" required maxlength="2000" rows="7"></textarea>    
                <label for="file">上传文件</label>
                <input type="file" id="file" name="file">
    
                <input type="submit" id="submit-button" value="发布!">
            </form>
        </div>
    </div>


    <!-- Footer -->
    <footer>
        <p>&copy; 2024 DuckWan - 版权所有</p>
    </footer>
    
    <script>
        function disableSubmitButton() {
            var submitButton = document.getElementById('submit-button'); // 获取发布按钮
            submitButton.disabled = true; // 禁用按钮
            submitButton.value = '正在发布...'; // 修改按钮文字
        }
    </script>
</body>
</html>
