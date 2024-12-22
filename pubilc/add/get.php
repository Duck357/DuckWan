<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    
    // 获取文章发布码
    $code = $_POST['code'];
    
    if($code === "667788" || isset($_SESSION['loggedin'])){
        // 获取文章名称
        $name = $_POST['name'];
        
        // 获取作者代称
        $author = $_POST['author'];
        if(isset($_SESSION['loggedin'])){
            $author = $_SESSION['username'];
            $uid = $_SESSION['id'];
            $per = $_SESSION['root'];
        }else{
            $uid = -1;
            $per = -1;
        }
        
        $link = $_POST['link'];
        
        // 获取文章内容
        $article = $_POST['article'];
        
        $info = $_POST['info'];
        
        if(strlen($article) <= 1200 && strlen($info) <= 400){
            if(isset($name) && isset($author)){
                $file = $_FILES['file'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileType = $file['type'];
                $filePath = '上传错误';
                
                $sum = "error";
                
                if (file_exists('../json')) {
                    // 读取JSON文件内容
                    $jsonContent = file_get_contents('../json');
                    
                    // 解析JSON内容为PHP数组
                    $data = json_decode($jsonContent, true);
                    
                    // 检查是否解析成功
                    if (is_array($data)) {
                        $sum = $data['sum'];
                        $data[$sum+1] = array(
                            "title" => $name,
                            "user" => $author,
                            "time" => date('Y-m-d-H:i:s'),
                            "link" => $link,
                            "text" => $article,
                            "info" => $info,
                            "read" => 0,
                            "id" => $sum+1,
                            "uid" => $uid,
                            "per" => $per
                            );
                        $data['sum'] = $sum+1;
                        
                        $newJsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        
                        $filePath = '../file/'.($sum+1).'/'.$fileName;
                        if($fileSize >= 10){
                            mkdir("../file/".($sum+1), 0755);
                        }
                        
                        // 将JSON字符串写回文件
                        file_put_contents('../json', $newJsonContent);
                    } else {
                        echo "error:5298";
                    }
                } else {
                    echo "error:no file 7777";
                }
                if($fileSize >= 10){
                    if (move_uploaded_file($fileTmpName, $filePath)) {
                        chmod($filePath, 0700);
                    } else {
                        echo "error:move-out";
                    }
                }
            }
        }
    }else{
        echo '<script>文章码错误</script>';
    }
    header('Location: https://duckwan.link'.$_GET['type']);
    exit();
}
?>