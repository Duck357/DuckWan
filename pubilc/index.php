<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="image/icon.ico" />
    <title>DuckWan论坛首页</title>
    <meta name="description" content="牢记我们的网站https://www.duckwan.link/。DuckWan游戏交流论坛，分享游戏实用工具和资源。在论坛上发帖求助其他人，帮助别人解决问题。">
    <!-- 引入外部CSS文件 -->
    <link rel="stylesheet" href="/web/home.css">
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
                if(isset($_SESSION['loggedin'])){
                    echo '<li><a href="/login/">'.$_SESSION['username'].'</a></li><li><a href="/login/logout.php">退出登录</a></li>';
                }else{
                    echo '<li><a href="/login/">登录</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Left Sidebar (Article List) -->
        <div class="article-list">
            
            <?php
            // 文件路径
            $jsonFilePath = '../json';
            
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
                                
                                echo "<div class='article-item'>";
                                echo '<h3><a href="/read?id='.$article['id'].'">'.htmlspecialchars($article['title']).'</a></h3>';
                                echo '<div class="author-info">作者：'.$name.' | 发布时间：'.htmlspecialchars($article['time']).' | 阅读量：'.htmlspecialchars($article['read']).'</div><p>'.htmlspecialchars($article['info']).'</p><a href="/read?id='.$article['id'].'">阅读全文</a>';
                                echo "</div>";
                            }
                        }
                    }else{
                        echo "<div class='article-item'>";
                        echo '<h3><a href="https://duckwan.link/">这里空空如也</a></h3>';
                        echo '<div class="author-info">作者：呱呱呱呱 | 发布时间：?? | 阅读量：0</div><p>你来错地方了</p><a href="#">阅读全文</a>';
                        echo "</div>";
                    }
                } else {
                    echo "JSON文件解析失败，请检查文件格式是否正确。";
                }
            } else {
                echo "JSON文件不存在，请检查文件路径是否正确。";
            }
            ?>
            <!-- Add more article items as needed -->
        </div>

        <!-- Right Sidebar (Categories and Hot Posts) -->
        <div class="sidebar">
            <!-- Hot Categories -->
            <h3>热门分类</h3>
            <ul>
                <li><a href="#">编程技术</a></li>
                <li><a href="#">游戏讨论</a></li>
                <li><a href="#">影视娱乐</a></li>
                <li><a href="#">生活分享</a></li>
            </ul>

            <!-- Hot Posts -->
            <h3>热门帖子</h3>
            <ul>
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
                        echo '<li><a href="/read?id='.$articles[$i]['id'].'">'.$articles[$i]['title'].'  #'.$articles[$i]['user'].' - '.$articles[$i]['read'].'</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <!-- Pagination -->
    <div class="pagination">
        <a href="javascript:" onclick="redirectPage(-1)" >上一页</a>
        <?php 
        if(isset($_GET['page'])){
            $pagea = $_GET['page'];
        }else{
            $pagea = 1;
        }
        echo '<a href="javascript:" onclick="jumpPage(1)" class="page-num">1</a>';
        echo '<a href="javascript:" onclick="jumpPage('.$pagea.')" class="page-num">'.$pagea.'</a>';
        echo '<a href="javascript:" onclick="jumpPage('.ceil($totalArticles/10).')" class="page-num">'.ceil($totalArticles/10).'</a>';
        ?>
        <a href="javascript:" onclick="redirectPage(1)" >下一页</a>
    </div>

    <!-- Page Jump Input -->
    <div class="page-jump">
        <label for="page-input">跳转到页面:</label>
        <input type="number" id="page-input" placeholder="页码" min="1" max="<?php echo ceil($totalArticles/10); ?>">
        <button onclick="jumpToPage()">跳转</button>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 DuckWan - 版权所有</p>
    </footer>
    
    <script>
        function redirectPage(a) {
            // 获取当前页面的URL参数
            const params = new URLSearchParams(window.location.search);
            const page = parseInt(params.get('page')) || <?php echo $pagea; ?>; // 如果没有page参数，默认为1
            const nextPage = page + a; // 计算下一页的页码
        
            // 重定向到下一页
            window.location.href = 'https://duckwan.link/?page=' + nextPage;
        }
        function jumpToPage(){
            let a = document.getElementById("page-input").value;
            if(a >= 1 && a <= <?php echo ceil($totalArticles/10); ?>)
            window.location.href = 'https://duckwan.link/?page=' + a;
        }
        function jumpPage(a){
            window.location.href = 'https://duckwan.link/?page=' + a;
        }
    </script>
</body>
</html>
