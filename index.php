<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="google-adsense-account" content="ca-pub-7227962922931794">
    <link rel="icon" type="image/x-icon" href="image/icon.ico" />
    <title>鸭玩 DuckWan</title>
    <meta name="description" content="牢记我们的网站https://www.127.0.0.1/。DuckWan游戏交流论坛，分享游戏实用工具和资源。在论坛上发帖求助其他人，帮助别人解决问题。">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7227962922931794"
     crossorigin="anonymous"></script>
    <style>
		body {
            background-image: URL("https://bing.img.run/rand.php");
            font-family: Arial, sans-serif;
            margin: 0;
            background-size: auto 100vh;
            background-attachment: fixed;
            padding: 0;
            display: -webkit-flex;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .body-container {
            display: -webkit-flex;
            display: flex;
            width: 100%;
        }
        .article-list {
            display: -webkit-flex;
            display: flex;
            flex-direction: column;
            width: 60vw;
        }
        .article {
            margin-top: 15px;
            backdrop-filter: blur(0.5vh);
            background-color: rgba(240, 248, 255, 0.353);
            padding: 10px;
            border: 4px solid #dddddd95;
            transition: all 0.3s ease;
        }
        .article:hover {
            box-shadow: 1vh 1vh 1vh black;
            backdrop-filter: blur(2vh);
        }
        h2, h3, p {
            margin-bottom: 5px;
            overflow-x:auto;
            overflow-y: auto;
        }
        h2 {
            font-size: 3vh;
        }
        footer {
            backdrop-filter: blur(0.2vh);
            background-color: rgba(188, 255, 251, 0.524);
            height: 5vh;
            transition: all 0.3s ease;
            display: -webkit-flex;
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
        .list {
                
            backdrop-filter: blur(1vh);
            background-color: rgba(234, 255, 255, 0.579);
            margin-left: 2.5vw;
            margin-top: 5vh;
            width: 30vw;
            height: 85vh;
            padding: 10px;
            border-radius: 1vh;
            overflow-y: auto;
        }
        .ad {
            backdrop-filter: blur(1vh);
            background-color: rgba(234, 255, 255, 0.579);
            margin-left: 2.5vw;
            margin-top: 5vh;
            width: 30vw;
            height: 30vw;
            padding: 10px;
            border-radius: 1vh;
            overflow-y: auto;
            transition: all 0.3s ease;
            background-image: URL('file/img1.jpg');
            background-size: 30vw 30vw;
        }
        .ad:hover{
            box-shadow: 1vh 1vh 1vh black;
            background-color: rgba(234, 255, 255, 0.136);
        }
        .li {
            margin-top: 2vh;
            overflow-x:auto;
            overflow-y: auto;
            width: 28vw;
            height: 10vh;
        }
        .an {
            z-index: 1000;
            backdrop-filter: blur(0px);
            transform: translate(5vw, 3vw);
            justify-content: center;
            background-color: rgba(170, 215, 255, 0);
            color: rgba(0, 0, 0, 0);
            border-radius: 1vh;
            width: 90vw;
            height: 5vh; /* 设置最小高度 */
            position: fixed;
            transition: all 0.3s ease;
            text-align: center;
            overflow: hidden; /* 初始状态隐藏溢出的内容 */
        }

        .an:hover {
            backdrop-filter: blur(0.7vh);
            color: rgba(0, 0, 0, 0.642);
            background-color: rgba(170, 215, 255, 0.408);
            height: 40vh;
            overflow: auto; /* 展开时显示滚动条 */
        }
        .an h1{
            font-size: 3vh;
        }
        .an h2{
            display: inline;
            font-size: 2vh;
            margin-left: 2vw;
        }
        .an p{
            margin-top: 2vh;
        }
	</style>
</head>
<body>
    <div id="pc">
        <footer><p onclick="window.location.href = 'root.php'">后台</p><p onclick="window.location.href = '/about'">关于我们</p><p onclick="window.location.href = '/add'">创建帮助帖子</p></footer>
        
        <div class="body-container">
            <div class="article-list">
                <div class="an">
                    <?php
                        $data = json_decode(file_get_contents('text'),true);
                        echo nl2br('<h1 class="anh1"><strong>'.$data['info'].'</strong></h1>'.'<h2 class="anh2">发布人：'.$data['name'].'</h2><h2 class="anh2">发布时间：'.$data['time'].'</h2>'.'<p class="anp">'.$data['text'].'</p>');
                    ?>
                </div>
        <?php
            // 文件路径
            $jsonFilePath = 'json';
            
            // 检查文件是否存在
            if (file_exists($jsonFilePath)) {
                // 读取JSON文件内容
                $jsonContent = file_get_contents($jsonFilePath);
                
                // 解析JSON内容为PHP数组
                $articles = json_decode($jsonContent, true);
                
                // 检查是否解析成功
                if ($articles) {
                    // 获取文章总数
                    $totalArticles = $articles['sum'];
                    
                    // 输出文章总数
                    echo "<h1>文章总数：$totalArticles</h1>";
                    
                    // 遍历文章数组并展示每篇文章的内容
                    foreach (array_reverse($articles) as $key => $article) {
                        if ($key !== 'sum' && $key !== 'file') {
                            // 输出文章编号、标题、作者、时间和内容
                            echo "<div class='article' onclick='openLink(".$article['id'].")'>";
                            echo "<h3>" . htmlspecialchars($article['title']) . "</h3>";
                            echo "<p>作者：" . htmlspecialchars($article['user']) . "</p>";
                            echo "<p>发布时间：" . htmlspecialchars($article['time']) . "</p>";
                            echo "<p>" . htmlspecialchars($article['read']) . "阅读量</p>";
                            echo "<p style='max-height: 6em;'>简介：" . htmlspecialchars($article['info']) . "</p>";
                            echo "</div>";
                        }
                    }
                } else {
                    echo "JSON文件解析失败，请检查文件格式是否正确。";
                }
            } else {
                echo "JSON文件不存在，请检查文件路径是否正确。";
            }
            ?>
            </div>
            
            <div class="box">
                <div class="ad">

                </div>
                <div class="list">
                    <h2>阅读量榜单</h2>
                    <?php
                    $jsonContent = file_get_contents('json');
                    $data = json_decode($jsonContent, true);
                    $articles = array_filter($data, function ($key) {
                        return is_numeric($key) && $key !== 'sum';
                    }, ARRAY_FILTER_USE_KEY);
                    $readValues = [];
                    foreach ($articles as $key => $value) {
                        $readValues[$key] = $value['read'];
                    }
                    array_multisort($readValues, SORT_DESC, $articles);
                    
                    for($i = 0;$i < 15;$i++){
                        if($i+1 > $data['sum']){
                            echo "
                    <h3 class='li'>第" . $i+1 . "名<br>虚位以待<br><br></h3>";
                        }else{
                            echo "<h3 class='li'>第" . $i+1 . "名<br><a href='/read?id=" . $articles[$i]['id'] . "'>" . $articles[$i]['title'] . "</a><br>" . $articles[$i]['read'] . "阅读量</h3>";
                        }
                    }
                    ?>
                </div>
                <div class="ad">

                </div>
                
                <div class="ad">

                </div>
            </div>
        </div>
    </div>
    
    <!--<div id="phone">-->
    <!--    <h1>你是手机</h1>-->
    <!--</div>-->
    
    
	<script>
	    function fIsMobile(){
            if(window.screen.width < 1024){
        		return true;
        	}else{
        		return false;
        	}
        }
        function del(divId){
            document.getElementById(divId).remove();
        }
	
        // if (fIsMobile()) {
        //     if(confirm("你可能在使用手机浏览，是否进入手机页面📱?")){
        //         document.getElementById("pc").style.display = 'none';
        //         del('pc');
        //     }else{
        //         document.getElementById("phone").style.display = 'none';
        //         del('phone');
        //     }
        // } else {
        //     document.getElementById("phone").style.display = 'none';
        //     del('phone');
        // }

		function openLink(key) {
            window.location.href = '/read?id=' + key; // 你想要打开的链接
        }
	</script>
</body>
</html>
