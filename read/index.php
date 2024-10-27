
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="google-adsense-account" content="ca-pub-7227962922931794">
    <link rel="icon" type="image/x-icon" href="../image/icon.ico" />
    <title>文章阅读 鸭玩-DuckWan</title>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7227962922931794"
     crossorigin="anonymous"></script>
    <style>
        body {
            background-image: URL("https://bing.img.run/rand.php");
            background-size: auto 100vh;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }
        h2, h3, p {
            margin-bottom: 5px;
            overflow-x:auto;
            overflow-y: auto;
        }
        h3 {
            font-size: 3vh;
        }
        h2 {
            font-size: 5vh;
        }
        footer {
            backdrop-filter: blur(0.2vh);
            background-color: rgba(188, 255, 251, 0.524);
            height: 5vh;
            transition: all 0.3s ease;
            display: flex;
            justify-content: flex-end; 
            align-items: center;
            width: 100vw;
        }
        footer p{
            font-size: 4vh;
            margin: 0 10vw;
            cursor: pointer;
        }
        .dow {
            background-color: rgba(255, 166, 0, 0);
            width: 90vw;
            height: 13vh;
            backdrop-filter: blur(2vh);
            border-radius: 1vh;
        }
        .read {
                width: 90vw;
                transform: translate(2.5vw,3vh);
                background-color: rgba(240, 248, 255, 0.552);
                backdrop-filter: blur(2vh);
                margin-bottom: 10vh;
                margin-top: 5vh;
                padding: 2vh;
        }
    </style>
</head>
<body>
    <footer><p onclick="window.location.href = '/about'">关于我们</p><p onclick="window.location.href = '/add'">创建帮助帖子</p><p onclick="window.location.href = 'https://127.0.0.1'">首页</p></footer>

    <div class="read">
        <?php
        // 文件路径
        $jsonFilePath = '../json';
        
        // 检查文件是否存在
        if (file_exists($jsonFilePath)) {
            // 读取JSON文件内容
            $jsonContent = file_get_contents($jsonFilePath,JSON_UNESCAPED_UNICODE);
            
            // 解析JSON内容为PHP数组
            $articles = json_decode($jsonContent, true);
            
            // 检查是否解析成功
            if ($articles) {
                if ($_GET['id'] && isset($articles[$_GET['id']])) {
                    $article = $articles[$_GET['id']];
                    $articles[$_GET['id']]['read']++;
                    file_put_contents($jsonFilePath, json_encode($articles,JSON_UNESCAPED_UNICODE));
                    // 输出文章内容
                    echo "<h2>" . htmlspecialchars($article['title']) . "</h2>";
                    echo "<p>作者：" . htmlspecialchars($article['user']) . "</p>";
                    echo "<p>发布时间：" . htmlspecialchars($article['time']) . "</p>";
                    echo "<p>" . htmlspecialchars($article['read'])+1 . "阅读</p>";
                    echo "<p>简介：" . nl2br(htmlspecialchars($article['info'])) . "</p>";
                    echo "<h3>" . nl2br(htmlspecialchars($article['text'])) . "</h3>";
                } else {
                    echo "没有找到指定的文章。";
                }
            } else {
                echo "error:0077";
            }
        } else {
            echo "error:3365";
        }
        ?>
    </div>
    
    <center>
        <div class="dow">
            <?php
            $a = 0;
            $directory = '../file/'.$_GET['id'];
            $files = glob($directory . '/*');
            if (count($files) > 0) {
                echo("<a style='font-size: 3vh;' href='https://127.0.0.1/file/".$_GET['id']."/".array_map('basename', $files)[0]
."' download='".array_map('basename', $files)[0]
."'>".array_map('basename', $files)[0]);
            } else {
                $a = 1;
            }
            
            $data = json_decode(file_get_contents('../json',JSON_UNESCAPED_UNICODE), true);
            if($data[$_GET['id']]['link'] != ''){
                echo '<br><a style="font-size: 3vh;" href='.$data[$_GET['id']]['link'].'>不限速直链下载</a>';
            }else{
                $a++;
                if($a === 2){
                    echo "<h2>此文章没有可下载文件</h2>";
                }
            }
            ?>
        </div>
    </center>
</html>
