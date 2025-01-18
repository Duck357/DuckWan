<?php
session_start();
if(isset($_SESSION['loggedin'])){
if($_SESSION['root'] == 0){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 初始化错误消息变量
        $error = "无错误";
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $info = isset($_POST['info']) ? $_POST['info'] : '';
        $text = isset($_POST['text']) ? $_POST['text'] : '';
        
        $data = json_decode(file_get_contents('../text'),true);
        $data[intval($data['n'])+1]['name'] = $name;
        $data[intval($data['n'])+1]['info'] = $info;
        $data[intval($data['n'])+1]['text'] = $text;
        $data[intval($data['n'])+1]['time'] = date('Y-m-d H:i:s');
        $data['n'] = intval($data['n'])+1;
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        file_put_contents('../text',json_encode($data,JSON_UNESCAPED_UNICODE));
    
        header('Location: root.php');
        exit();
    }
}
}
?>