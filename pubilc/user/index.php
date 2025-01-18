<?php
session_start();

include("../../db/db.php");

// 使用预处理语句
$uid = $conn->real_escape_string($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM `user` WHERE `id` = ? AND `name` IS NOT NULL AND `password` IS NOT NULL AND `image` IS NOT NULL AND `info` IS NOT NULL AND `per` IS NOT NULL AND `color` IS NOT NULL AND `json` IS NOT NULL;");
$stmt->bind_param("i", $uid); // "i" 表示一个整数类型的参数

    $stmt->execute();
    $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $uuu = array(
                "name" => $row['name'],
                "color" => $row['color'],
                "image" => $row['image'],
                "per" => $row['per'],
                "info" => $row['info']
                );
            $a = "游客用户";
            if($row['per'] == 0){
                $a = "管理员";
            }else if($row['per'] == 1){
                $a = "高级用户";
            }else if($row['per'] == 2){
                $a = "中级用户";
            }else if($row['per'] == 3){
                $a = "普通用户";
            }else if($row['per'] == 4){
                $a = "捐赠者";
            }
        }
    $stmt->close();
// 关闭连接
$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../image/icon.ico" />
    <title><?php echo $uuu['name']." - DuckWan用户"; ?></title>
    <?php
    echo '<meta name="description" content="'.$uuu['info'].'">';
    ?>
    <style>
        /* 禁止页面左右滑动 */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
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

        /* Profile Section */
        .profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 5px; /* 让个人简介与主内容有一定间距 */
        }

        .profile .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: <?php echo $uuu['color']; ?>;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
            color: #333;
        }

        .profile h2 {
            font-size: 1.5rem;
            margin-top: 10px;
            color: #333;
        }

        .profile p {
            font-size: 1rem;
            color: #777;
        }

        /* 保证每篇文章的宽度固定 */
        .card {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            width: 100%;  /* 保证卡片宽度不变化 */
            width: 80vw; /* 控制最大宽度 */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card a{
            display: inline-block;
            color: #007bff;
            text-decoration: none;
        }
        .card a:hover{
            text-decoration: underline;
        }
        
        /* 确保内容区不会无限扩展 */
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            width: auto;
            margin-top: 40px;
        }


        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .card h1 {
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: #333;
        }

        .card p {
            font-size: 1rem;
            color: #555;
        }

        /* Loading spinner */
        .loading {
            display: none;
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-top: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        
        /* Load More Button */
        .load-more {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .load-more:hover {
            background-color: #0056b3;
        }

        .load-more:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

    </style>
</head>

<body>

    <!-- Header Section -->
    <header>
        <div class="logo">DuckWan</div>
        <nav>
            <ul>
                <li><a href="https://DuckWan.link/">首页</a></li>
                <li><a href="/add/">发布帖子</a></li>
                <li><a href="/box/">公告</a></li>
                <?php
                if(isset($_SESSION['loggedin'])){
                    echo '<li><a href="/login/">'.$_SESSION['username'].'</a></li><li><a href="/login/logout.php">退出登录</a></li>';
                }else{
                    echo '<li><a href="/login/">登录</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <div class="main-content">
        <!-- Profile Section -->
        <div class="profile">
            <div class="avatar">
                <?php
                echo $uuu['image']."</div><h2>".$a . '-' . $uuu['name']."</h2><p>".$uuu['info']."</p>";
                ?>
        </div>
        <div class="content" id="content">
            <!-- 文章内容会动态加载在这里 -->
        </div>

        <!-- Loading Spinner -->
        <div class="loading" id="loading"></div>
        
        <button class="load-more" id="loadMoreButton" onclick="loadPosts()">加载更多</button>
    </div>

    <script>
        // 模拟数据
        const posts = [
            <?php
            foreach (json_decode(file_get_contents('../../json'),true) as $page){
                if(isset($page['uid'])){
                    if($page['uid'] == $_GET['id']){
                        echo("{ title: '".$page['title']."', date: '".$page['time']."', views: '".$page['read']."', id: '".$page['id']."'},");
                    }
                }
            }
            ?>
            // 可以继续添加更多的文章
        ];

        let postIndex = 0;
        const postsPerLoad = 3;  // 每次加载3篇文章

        function loadPosts() {
            const contentDiv = document.getElementById('content');
            const loadingDiv = document.getElementById('loading');
            const loadMoreButton = document.getElementById('loadMoreButton');

            loadingDiv.style.display = 'block';  // 显示加载动画
            loadMoreButton.disabled = true;  // 禁用按钮，防止重复点击

            setTimeout(() => {
                const postsToLoad = posts.slice(postIndex, postIndex + postsPerLoad);
                postsToLoad.forEach(post => {
                    const cardDiv = document.createElement('div');
                    cardDiv.classList.add('card');
                    cardDiv.innerHTML = `
                        <h1>${post.title}</h1>
                        <p>${post.date} | ${post.views}阅读</p>
                        <a href="/read/?id=${post.id}">阅读全文</a>
                    `;
                    contentDiv.appendChild(cardDiv);
                });

                postIndex += postsPerLoad;
                loadingDiv.style.display = 'none';  // 隐藏加载动画

                // 如果还有更多文章，启用加载按钮
                if (postIndex < posts.length) {
                    loadMoreButton.disabled = false;
                } else {
                    loadMoreButton.textContent = '没有更多内容了';
                    loadMoreButton.disabled = true;
                }
            }, 200);  // 模拟加载延迟
        }
        loadPosts();
    </script>

</body>
</html>
