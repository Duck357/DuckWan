<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="google-adsense-account" content="ca-pub-7227962922931794">
    <link rel="icon" type="image/x-icon" href="../image/icon.ico" />
    <title>上传帖子 鸭玩-DuckWan</title>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7227962922931794"
     crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            background-image: URL("https://bing.img.run/rand.php");
            background-size: auto 100vh;
            background-attachment: fixed;
        }
        h2, h3, p {
            margin-bottom: 5px;
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
        .edit {
                backdrop-filter: blur(1vh);
            width: 90vw;
            max-width: 600px; /* Limit the width for better readability */
            margin: 20px auto; /* Center the edit box */
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
</head>
<body>
    <footer>
        <p onclick="window.location.href='/about'">关于我们</p>
        <p onclick="window.location.href='/add'">创建帮助帖子</p>
        <p onclick="window.location.href='https://127.0.0.1'">首页</p>
    </footer>
    <center>
        <div class="edit">
            <div class="input-container">
                <form action="get.php" method="post" enctype="multipart/form-data">
                    <label for="name">文章名称:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="author">作者代称<br>(谁都可以使用所以建议使用自己姓名)</label>
                    <input type="text" id="author" name="author" required><br><br>
                    
                    <input type="password" id="code" name="code" placeholder="文章发布码" required><br><br>
                    
                    <label for="link">跳转链接按钮（可不填）</label>
                    <input type="text" id="link" name="link">
                    
                    <label for="info">简介</label>
                    <textarea id="info" name="info" required maxlength="100"></textarea>

                    <label for="article">文章</label>
                    <textarea id="article" name="article" required required maxlength="500"></textarea>
                    

                    <label for="file">上传文件:</label>
                    <input type="file" id="file" name="file">

                    <input type="submit" value="发布!">
                </form>
            </div>
        </div>
    </center>
</body>
</html>
