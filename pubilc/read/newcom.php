<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_SESSION['loggedin'])){
        $comment = htmlspecialchars($_POST['comment']); // 防止 XSS
        if(strlen($comment) <= 400 && isset($comment) && $comment != ""){
            echo $_SESSION['username']." - ".$comment;
            
            $jsonFilePath = '../../json';
                
            // 检查文件是否存在
            if (file_exists($jsonFilePath)) {
                // 读取JSON文件内容
                $jsonContent = file_get_contents($jsonFilePath,JSON_UNESCAPED_UNICODE);
                
                // 解析JSON内容为PHP数组
                $articles = json_decode($jsonContent, true);
                if(count($articles[$_GET['id']]['comment']) < 20 && isset($_GET['id']) && isset($articles[$_GET['id']])){
                    $commentKey = $_SESSION['username'] . ' - ' . date('Y年m月d日 H:i:s') . ' #' . (htmlspecialchars(count($articles[$_GET['id']]['comment']) + 1)) . '楼';
                    
                    // 将评论内容保存在对应的键中
                    $articles[$_GET['id']]['comment'][$commentKey] = $comment;
                }
                file_put_contents($jsonFilePath,json_encode($articles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
    else {
        echo "<script>alert('请登录后再发表评论');window.history.back();</script>";
    }
}
?>