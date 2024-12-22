<?php
session_start();
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="google-adsense-account" content="ca-pub-7227962922931794">
    <link rel="icon" type="image/x-icon" href="../image/icon.ico" />
    <title>上传帖子 鸭玩-DuckWan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(0, 145, 255);
            display: -webkit-flex;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        .edit h2, h3, p {
            margin-bottom: 5px;
        }
        .edit h3 {
            font-size: 3vh;
        }
        .edit h2 {
            font-size: 5vh;
        }
        .edit {
            backdrop-filter: blur(1vh);
            width: 90vw;
            max-width: 600px; /* Limit the width for better readability */
            margin: 20px auto; 
            box-shadow: 0 1vh 1vh rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.344);
        }
        .input-container {
            padding: 20px;
        }
        
        .input-container label {
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }
        
        .input-container input[type='text'],
        .input-container textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ddddddb3;
            backdrop-filter: blur(1vh);
            background-color: rgba(255, 255, 255, 0.403);
            border-radius: 4px;
            transition: border-color 0.3s ease;
            resize: vertical; /* Allow resizing vertically */
        }
        
        .input-container input[type='text']:focus,
        .input-container textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        
        .input-container input[type='submit'] {
            padding: 10px 15px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }
        
        .input-container input[type='submit']:hover {
            background-color: #0056b3;
        }
        textarea {
            min-height: 150px; /* Minimum height for the textarea */
        }
    </style>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/layui/2.9.20/layui.js" integrity="sha512-KjLs85CHuxdUNAJSixDB/tWtF/Qb+O6tNNshU/FcsNaXZcYQsmCVzcj0JvbvE1UiQBZwZyOLr38xf+BUjFx6Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/layui/2.9.20/layui.min.js" integrity="sha512-z2UATz8GsuKCOTbw4ML/6YvZeAhEQsm3mSawEWnxdq65bDtMoXp501kvS93JyZ95onfEZqf/vykl3M4If4nGaw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/layui/2.9.20/css/layui.css" integrity="sha512-5rZD2F6qzLXTE2GMfmSIRf74lSwr1TcA0BnhK7ENkjvYjCYL/8yDth0XKKmAehppPmOOuijwPuZus+63yK10Bw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/layui/2.9.20/css/layui.min.css" integrity="sha512-54WyiQNseHG9u6y5QlRZQU5Xqh1llgctSRJPE26UOlXB22P+Bnt6jZT8+bf5GfyiNaY77ZLdGcgtLF3NuyVvWQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    
    <center>
        <div class="edit">
            <div class="input-container">
                <form action="get.php" method="post" enctype="multipart/form-data">
                    <input type="text" id="name" name="name" placeholder="文章名称" class="layui-input" maxlength="40" required><br>
                    <input type="text" id="author" name="author" placeholder="作者代称" class="layui-input" maxlength="20" required><br>
                    <input type="text" id="code" name="code" placeholder="文章发布码" class="layui-input" maxlength="20" required<?php
                        if(isset($_SESSION['loggedin'])) echo " value='IDUCK667788' disabled='disabled'";
                        ?>><br>
                    <input type="text" id="link" name="link" placeholder="跳转链接(选填)" class="layui-input" maxlength="100"><br>
                    <textarea id="info" name="info" placeholder="简介" class="layui-textarea" required maxlength="200" rows="4"></textarea><br>
                    <textarea id="article" name="article" placeholder="文章" class="layui-textarea" required maxlength="600" rows="7"></textarea><br>
                    

                    <label for="file">上传文件:</label>
                    <input type="file" id="file" name="file">

                    <input type="submit" value="发布!">
                </form>
            </div>
        </div>
    </center>
</body>
</html>