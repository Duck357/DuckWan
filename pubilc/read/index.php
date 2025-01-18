<?php
session_start();
// 文件路径
$jsonFilePath = '../../json';

// 检查文件是否存在
if (file_exists($jsonFilePath)){
    $jsonContent = file_get_contents($jsonFilePath,JSON_UNESCAPED_UNICODE);
    $articles = json_decode($jsonContent, true);
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://duckwan.link/image/icon.ico" />
    <?php
    echo '<meta name="description" content="'.$articles[$_GET['id']]['info'].'|'.$articles[$_GET['id']]['text'].'"><title>'.$articles[$_GET['id']]['title'].' - DuckWan</title>'  ?>
    <style>
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

        .main-content {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .article-meta {
            color: #666;
            margin-bottom: 20px;
        }
        .comment-section {
            margin-top: 40px;
        }
        .comment-form textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
            padding: 10px;
        }
        .comment-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .comment {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .comment-author {
            font-weight: bold;
        }
        .comment-date {
            color: #888;
            font-size: 0.8em;
        }
        .comments {
            display: flex;
            flex-direction: column-reverse;
        }
        .article-download {
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    
        .article-download h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #333;
        }
    
        .file-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
    
        .file-list li {
            margin-bottom: 10px;
        }
    
        .download-link {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
    
        .download-link:hover {
            text-decoration: underline;
        }
    
        .file-size {
            color: #888;
            font-size: 0.9em;
            margin-left: 10px;
        }
        
        .article-meta span a{
            display: inline-block;
            color: #007bff;
            text-decoration: none;
        }
        
        .article-meta span a:hover{
            text-decoration: underline;
        }
    </style>
</head>
<body>
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

    <main class="main-content">
        <article>
            <?php
            if(isset($_GET['id']) && isset($articles[$_GET['id']])){
                $article = $articles[$_GET['id']];
                $articles[$_GET['id']]['read']++;
                file_put_contents($jsonFilePath, json_encode($articles,JSON_UNESCAPED_UNICODE));
                
                echo "<h1>".htmlspecialchars($article['title'])."</h1>";
            ?>
            <div class="article-meta">
                <?php
                    echo "<span>发布时间：".htmlspecialchars($article['time'])."</span> | <span>阅读量：".htmlspecialchars($article['read']+1)."</span> |<span>作者：";
                    if($article['uid'] != -1)
                        echo("<a href='/user?id=".$article['uid']."'>");
                    $name = htmlspecialchars($article['user']);
                    $name = htmlspecialchars($article['per']) == -1 ? '游客 ~ ' . $name : 
                            (htmlspecialchars($article['per']) == 0 ? '管理员 ~ ' . $name : 
                            (htmlspecialchars($article['per']) == 1 ? '高级用户 ~ ' . $name : 
                            (htmlspecialchars($article['per']) == 2 ? '中级用户 ~ ' . $name : 
                            (htmlspecialchars($article['per']) == 3 ? '普通用户 ~ ' . $name : 
                            (htmlspecialchars($article['per']) == 4 ? '捐赠者 ~ ' . $name : $name)))));
                    echo $name.($article['uid'] != -1 ? "</a>" : "")."</span>";
                ?>
            </div>
            <div class="article-content">
                <?php
                    echo "<p>".nl2br(htmlspecialchars($article['text']))."</p>";
                }else {
                    echo "找不到此文章哦";
                }
                ?>
                <div class="article-download">
                    <h2>文件下载</h2>
                    
                    <ul class="file-list">
                        <li>
                            <?php
                            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                            $aa = 0;
                            if ($id === null || $id === false) {
                                echo '无效的文章 ID';
                            }else{
                                // 构造文件夹路径
                                $directory = '../../file/' . $id . '/';
                                $files = glob($directory . '/*');
                                
                                // 处理外部链接
                                if ($articles[$_GET['id']]['link'] != '' && filter_var($articles[$_GET['id']]['link'], FILTER_VALIDATE_URL)) {
                                    echo "<p>点击链接下载相关文件：</p>";
                                    echo '<a href="' . htmlspecialchars($articles[$id]['link']) . '" target="_blank" class="download-link">下载链接: 点击我</a>';
                                    echo '<span class="file-size">(大小: 请访问链接)</span><br>';
                                    $aa = 1;
                                }
                                // 检查文件是否存在
                                if (empty($files) || empty($files[0])) {
                                    if($aa == 0)
                                        echo '<p>该文章没有相关文件可供下载</p>';
                                }else{
                                    // 获取第一个文件的路径和名称
                                    $filePath = realpath($files[0]);
                                    $fileName = basename($filePath);
                                    
                                    // 计算文件大小
                                    $fileSize = round(filesize($filePath) / 1024 / 1024, 2);
                                    
                                    // 初始化下载 token 的存储
                                    if (!isset($_SESSION['download_token']) || !is_array($_SESSION['download_token'])) {
                                        $_SESSION['download_token'] = [];
                                    }
                                    
                                    // 生成唯一的 token
                                    $token = bin2hex(random_bytes(32)); // 生成 64 字符的随机字符串
                                    $_SESSION['download_token'][$token] = [
                                        'file_path' => $filePath, // 保存文件的绝对路径
                                        'expire' => time() + 120, // 设置过期时间为 2 分钟
                                    ];
                                    
                                    // 输出下载链接和文件大小
                                    if(!$aa)
                                        echo '<p>点击链接下载相关文件：</p>';
                                    echo '<a href="gt.php?token=' . $token . '" target="_blank" class="download-link">下载文件: ' . htmlspecialchars($fileName) . '</a>';
                                    echo '<span class="file-size">(大小: ' . $fileSize . 'MB)</span>';
                                }
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </article>

        <section class="comment-section">
            <h2>评论区</h2>
            <form class="comment-form" method="post" action="newcom.php?id=<?php echo $_GET['id'] ?>" onsubmit="disableSubmitButton()">
                <textarea placeholder="请输入您的评论...请不要水评，水评记1次，5次违反者封号处理" name="comment" maxlength="170"></textarea>
                <button type="submit">发表评论</button>
            </form>
            <div class="comments">
                <?php
                    if(isset($_GET['id']) && isset($articles[$_GET['id']])){
                        $comments = $article['comment']; // 保留键名
                        foreach ($comments as $author => $comment) {
                            echo '<div class="comment">';
                            echo '<p class="comment-author">' . htmlspecialchars($author) . '</p>';
                            echo '<p class="comment-content">' . htmlspecialchars($comment) . '</p>';
                            echo '</div>';
                        }
                        if(count($comments) == 0){
                            echo '<div class="comment">';
                            echo '<p class="comment-author">' . '这里空空如也' . '</p>';
                            echo '</div>';
                        }
                    }
                ?>
            </div>
        </section>
    </main>
    
    <script>
    function disableSubmitButton() {
        // 获取提交按钮
        var submitButton = document.querySelector('.comment-form button');
        // 禁用提交按钮
        submitButton.disabled = true;
        // 更改按钮文本（可选）
        submitButton.innerText = '正在提交...';
    }
    </script>
</body>
</html>