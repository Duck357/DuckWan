<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="google-adsense-account" content="ca-pub-7227962922931794">
    <link rel="icon" type="image/x-icon" href="../image/icon.ico" />
    <title>文章阅读 鸭玩-DuckWan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(0, 145, 255);
            display: -webkit-flex;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100vw;
            min-height: 100vh;
        }
        .read h2, h3, p , .dow h2, h3, p {
            margin-bottom: 5px;
            overflow-x:auto;
            overflow-y: auto;
        }
        .dow h3 , .read h2 {
            font-size: 25px;
        }
        .dow h2 , .read h2 {
            font-size: 50px;
        }
        .dow {
            background-color: rgba(255, 166, 0, 0);
            width: 90vw;
            height: 100px;
            backdrop-filter: blur(2vh);
            border-radius: 1vh;
        }
        .read {
            width: 90vw;
            transform: translate(0vw,3vh);
            background-color: rgba(240, 248, 255, 0.552);
            backdrop-filter: blur(2vh);
            margin-bottom: 50px;
            margin-top: 10px;
            padding: 20px;
        }
        .info {
            display: flex;
            flex-wrap: wrap;
            font-size: 20px;
            margin-top: 20px;
            min-height: 50px;
            justify-content: space-around;
            margin-bottom: 30px;
    </style>
    <script>
        function openlink(a) {
            window.location.href = `https://duckwan.link/user?id=${a}`; 
        }
    </script>
	<link rel="stylesheet" href="https://unpkg.com/mdui@2/mdui.css">
    <script src="https://unpkg.com/mdui@2/mdui.global.js"></script>
</head>
<body>
    <mdui-card variant = "outlined" style="width: 90vw;height: 80px;display:flex;flex-direction:row-reverse;align-items:center;justify-content:center;">
        <div style="display:flex;flex-direction:row-reverse;margin-right:70px">
        <?php
        if(isset($_SESSION['loggedin'])){
            echo '<mdui-dropdown><mdui-button slot="trigger" variant="text" style="width: 60px;height: 60px;"><div style="font-size: 50px;background-color: '.$_SESSION['color'].';width: 60px;height: 60px;border-radius: 4px;text-align: center;color: #000000;">' . $_SESSION['img'] . '</div></mdui-button>
              <mdui-menu>
                <mdui-menu-item href="https://duckwan.link/login/">用户中心</mdui-menu-item>
                <mdui-menu-item href="https://duckwan.link/login/logout.php">退出登录</mdui-menu-item>
              </mdui-menu>
            </mdui-dropdown><h2>'.$_SESSION['username'].'</h2>';
        }else{
            echo '<mdui-button href="/login/" style="margin-right:70px;margin-left:70px">登录</mdui-button>';
        }
        ?>
        </div>
        <mdui-button id="ggb" style="margin-right:70px">公告</mdui-button>
        <mdui-button variant="elevated" style="margin-right:70px" href="https://duckwan.link/add/">发布文章</mdui-button>
        <mdui-button variant="elevated" style="margin-right:70px" href="https://duckwan.link/">主页</mdui-button>
        
        
            <mdui-dialog class="example-dialog" close-on-overlay-click>
                <mdui-list>
                  <mdui-collapse accordion>
                    <?php
                        $data = json_decode(file_get_contents('../text'),true);
                        foreach (array_reverse($data) as $key => $value){
                            if ($key !== 'n') {
                                echo '<mdui-collapse-item><mdui-list-item slot="header">'.$value['info'].' - '.$value['time'].'</mdui-list-item><div style="margin-left: 2.5rem"><mdui-list-item>'.
                                nl2br('<h1 class="anh1"><strong>'.$value['info'].'</strong></h1>'.'<h2 class="anh2">发布人：'.$value['name'].'</h2><h3 class="anh2">发布时间：'.$value['time'].'</h3>'.'<p class="anp">'.$value['text'].'</p>')
                                .'</mdui-list-item></div></mdui-collapse-item>';
                            }
                        }
                    ?>
                    
                  </mdui-collapse>
                </mdui-list>
          <mdui-button>关闭</mdui-button>
        </mdui-dialog>
        
        
        <script>
          const dialog = document.querySelector(".example-dialog");
          const openButton = document.getElementById('ggb');
          const closeButton = dialog.querySelector("mdui-button");
        
          openButton.addEventListener("click", () => dialog.open = true);
          closeButton.addEventListener("click", () => dialog.open = false);
        </script>
    </mdui-card>
    
    <a href="https://github.com/Duck357/DuckWan" class="github-corner" aria-label="View source on GitHub"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#70B7FD; color:#fff; position: absolute; top: 0; border: 0; left: 0; transform: scale(-1, 1);" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"/><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"/><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"/></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7227962922931794" crossorigin="anonymous"></script>
    <!-- 文章阅读顶部广告 -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7227962922931794"
         data-ad-slot="5533232620"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    
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
                    
                    $name = htmlspecialchars($article['user']);
                    if(htmlspecialchars($article['uid']) == -1){
                        $name = '<strong>游客-</strong>'.htmlspecialchars($article['user']);
                    }
                    else if(htmlspecialchars($article['per']) == 0){
                        $name = '<strong>管理员-</strong>'.htmlspecialchars($article['user']);
                    }
                    else if(htmlspecialchars($article['per']) == 1){
                        $name = '<strong>高级用户-</strong>'.htmlspecialchars($article['user']);
                    }
                    else if(htmlspecialchars($article['per']) == 2){
                        $name = '<strong>中级用户-</strong>'.htmlspecialchars($article['user']);
                    }
                    else if(htmlspecialchars($article['per']) == 3){
                        $name = '<strong>普通用户-</strong>'.htmlspecialchars($article['user']);
                    }
                    else if(htmlspecialchars($article['per']) == 4){
                        $name = '<strong>捐赠者-</strong>'.htmlspecialchars($article['user']);
                    }
                    
                    file_put_contents($jsonFilePath, json_encode($articles,JSON_UNESCAPED_UNICODE));
                    // 输出文章内容
                    echo "<h2>" . htmlspecialchars($article['title']) . "</h2><mdui-card clickable class='info'";
                    if(isset($article['uid']) && $article['uid'] != -1){
                        echo " onclick='openlink(".$article['uid'].");'";
                    }
                    echo " ><div><p>作者：" . $name . "</p>";
                    echo "<p>发布时间：" . htmlspecialchars($article['time']) . "</p></div>";
                    echo "<p>" . htmlspecialchars($article['read'])+1 . "阅读</p></mdui-card>";
                    echo "<div class='info'><p>" . nl2br(htmlspecialchars($article['info'])) . "</p></div>";
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
            $directory = '../file/'.$_GET['id'].'/';
            $files = glob($directory . '/*');
            if (count($files) > 0) {
                echo("<a style='font-size: 3vh;' href='https://duckwan.link/file/".$_GET['id']."/".array_map('basename', $files)[0]."' download='".array_map('basename', $files)[0]."'>".array_map('basename', $files)[0]);
            } else {
                $a = 1;
            }
            
            $data = json_decode(file_get_contents('../json',JSON_UNESCAPED_UNICODE), true);
            if($data[$_GET['id']]['link'] != ''){
                echo '<br><a style="font-size: 3vh;" href='.$data[$_GET['id']]['link'].'>文件下载链接🔗</a>';
            }else{
                $a++;
                if($a === 2){
                    echo "<h2>此文章没有可下载文件</h2>";
                }
            }
            ?>
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7227962922931794"
                 crossorigin="anonymous"></script>
            <!-- 文章阅读广告 -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-7227962922931794"
                 data-ad-slot="3357433331"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </center>
</html>