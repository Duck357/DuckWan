<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="google-adsense-account" content="ca-pub-7227962922931794">
    <link rel="icon" type="image/x-icon" href="image/icon.ico" />
    <title>鸭玩 DuckWan</title>
    <meta name="description" content="牢记我们的网站https://www.duckwan.link/。DuckWan游戏交流论坛，分享游戏实用工具和资源。在论坛上发帖求助其他人，帮助别人解决问题。">
    <style>
		body {
            font-family: Arial, sans-serif;
            background-color: rgb(0, 145, 255);
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
            margin-top: 25px;
            padding: 10px;
        }
        article-list h2, h3, p {
            margin-bottom: 5px;
            overflow-x:auto;
            overflow-y: auto;
        }
        article-list h2 {
            font-size: 30px;
        }
        .list {
            margin-left: 2.5vw;
            margin-top: 25px;
            width: 30vw;
            height: 85vh;
            overflow-y: auto;
        }
        .ad1 {
            backdrop-filter: blur(1vh);
            background-color: rgba(234, 255, 255, 0.579);
            margin-left: 2.5vw;
            margin-top: 25px;
            width: 30vw;
            height: 30vw;
            padding: 10px;
            border-radius: 1vh;
            overflow-y: auto;
            background-image: URL('image/1.jpg');
            background-size: 100% auto;
        }
        .ad2 {
            background-color: rgba(234, 255, 255, 0.579);
            margin-left: 2.5vw;
            margin-top: 25px;
            width: 30vw;
            height: 30vw;
            padding: 10px;
            border-radius: 1vh;
            overflow-y: auto;
            background-image: URL('image/2.png');
            background-size: 100% auto;
        }
        .li {
            font-size: 20px;
        }
        .qh {
          margin-top: 20px;
          margin-bottom: 20px;
          width: 60vw;
          height: 50px;
          flex-wrap: wrap;
          justify-content: space-around;
          display: flex;
        }
        .qh input{
            height: 40px;
            width: 20vw;
            font-size: 30px;
        }
	</style>
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
        <mdui-button variant="elevated" style="margin-right:70px" href="https://duckwan.link/root.php">后台</mdui-button>
        
        
            <mdui-dialog class="example-dialog" close-on-overlay-click>
                <mdui-list>
                  <mdui-collapse accordion>
                    <?php
                        $data = json_decode(file_get_contents('./text'),true);
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
    
    <mdui-card variant="elevated" style="width: 80%;max-height: 400px;margin-top: 30px;overflow-y:auto;">
        <mdui-list>
              <mdui-collapse accordion>
                <?php
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
    </mdui-card>
    
    <a href="https://github.com/Duck357/DuckWan" class="github-corner" aria-label="View source on GitHub"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#70B7FD; color:#fff; position: absolute; top: 0; border: 0; left: 0; transform: scale(-1, 1);" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"/><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"/><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"/></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>
    
    <div class="body-container">
        <div class="article-list">
            
    <?php
        // 文件路径
        $jsonFilePath = './json';
        
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
                $sum = 0;
                $d = 1;
                if (isset($_GET['page'])){
                    $sum += ($_GET['page']-1)*10;
                    $d = $_GET['page'];
                }
                
                if($d >= 1 && $d <= ceil($totalArticles/10)){
                    $art = array_slice(array_reverse($articles) , $sum , 10 , true);
                    // 遍历文章数组并展示每篇文章的内容
                    foreach ($art as $key => $article) {
                        if ($key !== 'sum' && $key !== 'file') {
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
                            // 输出文章编号、标题、作者、时间和内容
                            echo "<mdui-card clickable class='article' onclick='openLink(".$article['id'].")'>";
                            echo "<h3>" . htmlspecialchars($article['title']) . "</h3>";
                            echo "<p>作者：" . $name . "</p>";
                            echo "<p>发布时间：" . htmlspecialchars($article['time']) . "</p>";
                            echo "<p>" . htmlspecialchars($article['read']) . "阅读量</p>";
                            echo "<p style='max-height: 6em;'>简介：" . htmlspecialchars($article['info']) . "</p>";
                            echo "</mdui-card>";
                        }
                    }
                }else{
                    echo "<mdui-card clickable class='article' onclick='openLink(0);'>";
                    echo "<h3>这里空空如也</h3>";
                    echo "<p>作者：呱呱呱呱</p>";
                    echo "<p>发布时间:???</p>";
                    echo "<p>" . "???" . "阅读量</p>";
                    echo "<p style='max-height: 6em;'>简介：你来错地方了</p>";
                    echo "</mdui-card>";
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
            <div class="ad1">
               
            </div>
            <mdui-card variant="elevated" class="list">
                <mdui-list-subheader><h2>阅读量榜单</h2></mdui-list-subheader>
                <?php
                $data = $articles;
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
                        echo "<h3 class='li'>第" . $i+1 . "名<br>虚位以待<br><br></h3>";
                    }else{
                        echo '
                              <mdui-collapse class="example-value">
                                <mdui-collapse-item>
                                  <mdui-list-item slot="header">'.$articles[$i]['title'].'</mdui-list-item>
                                  <div style="margin-left: 2.5rem">
                                    <mdui-list-item>'.($articles[$i]['uid'] !== -1 ? '<a href="/user?id='.$articles[$i]['uid'] .'">作者:'.$articles[$i]['user'].'</a>': '作者:'.$articles[$i]['user']).'</mdui-list-item>
                                  </div>
                                  <div style="margin-left: 2.5rem">
                                    <mdui-list-item><a href="/read?id='.$articles[$i]['id'].'">查看此文章</a></mdui-list-item>
                                  </div>
                                  <div style="margin-left: 2.5rem">
                                    <mdui-list-item>'.$articles[$i]['read'].'阅读量</mdui-list-item>
                                  </div>
                                  <div style="margin-left: 2.5rem">
                                    <mdui-list-item>'.$articles[$i]['time'].'</mdui-list-item>
                                  </div>
                                </mdui-collapse-item>
                                </mdui-collapse-item>
                              ';
                    }
                }
                ?>
                </mdui-collapse>
            </mdui-card>
            <div class="ad2">
                
            </div>
            
            <div class="ad2">
            </div>
        </div>
    </div>
    </div>
    
    <mdui-navigation-bar value="item-1" style="position: relative;">
        <?php
// <mdui-navigation-bar value="item-1" style="position: relative">
//   <mdui-navigation-bar-item icon="place" value="item-1">Item 1</mdui-navigation-bar-item>
//   <mdui-navigation-bar-item icon="commute" value="item-2">Item 2</mdui-navigation-bar-item>
//   <mdui-navigation-bar-item icon="people" value="item-3">Item 3</mdui-navigation-bar-item>
// </mdui-navigation-bar>
        
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }else{
            $page = 1;
        }
        
        
        echo '<mdui-navigation-bar-item value="页数">'.$page.'</mdui-navigation-bar-item>';
        echo '<mdui-navigation-bar-item value="页数">...</mdui-navigation-bar-item>';
        echo '<mdui-navigation-bar-item value="页数">'.ceil($totalArticles/10).'</mdui-navigation-bar-item></mdui-navigation-bar><mdui-navigation-bar value="item-1" style="position: relative">';
        
        if($page <= 1){
            echo '<mdui-navigation-bar-item label-visibility="labeled" value="<" onclick="redirectPage(-1)">️🚫</mdui-navigation-bar-item>';
        }else{
            echo '<mdui-navigation-bar-item value="<" onclick="redirectPage(-1)">⬅</mdui-navigation-bar-item>';
        }
        if($page >= ceil($totalArticles/10)){
            echo '<mdui-navigation-bar-item value="<" onclick="redirectPage(1)">️🚫</mdui-navigation-bar-item>';
        }else{
            echo '<mdui-navigation-bar-item value=">" onclick="redirectPage(1)">➡</mdui-navigation-bar-item>';
        }
        ?>
    </mdui-navigation-bar>
    
    <div class="qh">
      <mdui-text-field type="number" id="num" variant="filled" label="跳转至..." style="width:70%"></mdui-text-field>
      <mdui-button style="font-size:30px" variant="➡" onclick="if(document.getElementById('num').value !== ''){ window.location.href = 'https://DuckWan.link/index.php?page=' + document.getElementById('num').value; }">➡</mdui-button>
    </div>
    
	<script>
		function openLink(key) {
		    if(key == 0){
		        window.location.href = 'https://duckwan.link/';
		    }else{
                window.location.href = '/read?id=' + key;
		    }
        }
        function redirectPage(a) {
            // 获取当前页面的URL参数
            const params = new URLSearchParams(window.location.search);
            const page = parseInt(params.get('page')) || 1; // 如果没有page参数，默认为1
            const nextPage = page + a; // 计算下一页的页码
        
            // 重定向到下一页
            window.location.href = 'https://duckwan.link/index.php?page=' + nextPage;
        }
	</script>
</body>
</html>
