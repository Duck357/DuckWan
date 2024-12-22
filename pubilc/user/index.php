<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../image/icon.ico" />
    <title>用户主页</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(0, 145, 255);
            display: -webkit-flex;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            moz-user-select: -moz-none; 
            -moz-user-select: none; 
            -o-user-select:none; 
            -khtml-user-select:none; 
            -webkit-user-select:none; 
            -ms-user-select:none; 
            user-select:none;
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
        .ad {
            backdrop-filter: blur(1vh);
            background-color: rgba(234, 255, 255, 0.579);
            margin-left: 2.5vw;
            margin-top: 25px;
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
        .pages {
            min-height: 300px;
            width: 100vw;
            margin: 30px;
            border-radius: 20px;
            display: flex;
            flex-direction: column-reverse;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            overflow-y: auto;
        }
        .page {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            background-color: #6495ED;
            width: 50%;
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
    </style>
	<link rel="stylesheet" href="https://unpkg.com/mdui@2/mdui.css">
    <script src="https://unpkg.com/mdui@2/mdui.global.js"></script>
</head>

<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

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
        <mdui-button variant="elevated" style="margin-right:70px" href="https://duckwan.link/">首页</mdui-button>
        
        
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
            function openlink(a) {
                window.location.href = `https://duckwan.link/read?id=${a}`; // 使用模板字符串构建URL
            }
        
          const dialog = document.querySelector(".example-dialog");
          const openButton = document.getElementById('ggb');
          const closeButton = dialog.querySelector("mdui-button");
        
          openButton.addEventListener("click", () => dialog.open = true);
          closeButton.addEventListener("click", () => dialog.open = false);
        </script>
    </mdui-card>
    <center>
        <?php
        echo '<div style="font-size: 150px;background-color: '.$uuu['color'].';width: 200px;height: 200px;border-radius: 10px;margin: 20px;text-align: center;display:flex;justify-content:center;align-items:center">' . $uuu['image'] . '</div>';
        echo '<h2 style="font-size: 30px;margin: 20px;">'. $a . '-' . $uuu['name'] . '</h2>';
        echo '<h2 style="font-size: 20px;margin: 20px;">' . $uuu['info'] . '</h2>';
        ?>
        <?php
        echo "<div class='pages'>";
        foreach (json_decode(file_get_contents('../json'),true) as $page){
            if(isset($page['uid'])){
                if($page['uid'] == $_GET['id']){
                    echo ' <mdui-card clickable onclick="openlink('.$page['id'].');" variant = "outlined" class="page">
                    <h1 style="font-size: 20px;">'.$page['title'].'</h1>
                    <h2 style="font-size: 20px">'.$page['time'].'</h2>
                    <h2 style="font-size: 20px">'.$page['read'].'阅读</h2>
                    </mdui-card>
                    ';
                }
            }
        }
        echo "</div>";
        ?>
    </center>
</body>
</html>