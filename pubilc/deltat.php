<?php

session_start();
if(isset($_SESSION['loggedin'])){
if($_SESSION['root'] == 0){
    $data = json_decode(file_get_contents('../text'),true);
    $id = $_POST['id'];
    
    // 检查是否有数据被提交
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 初始化错误消息变量
        $error = "无错误";
        // 删除指定ID的元素
        unset($data[$id]);

        // 重新构建数组，确保键名是连续的
        $newData = array();
        $sum = $data['n'];
        for ($i = 1; $i <= $sum; $i++) {
            if ($i == $id) {
                continue; // 跳过要删除的ID
            }
            if ($i > $id) {
                $newData[$i - 1] = $data[$i];
            } else {
                $newData[$i] = $data[$i];
            }
        }
        $newData['n'] = $sum - 1; // 更新sum的值

        // 输出结果
        echo "状态: " . htmlspecialchars($error) . "<br>";
        file_put_contents('../text',json_encode($newData, JSON_UNESCAPED_UNICODE));
        header('Location: root.php');
        exit();
    }
}
}else{
    echo "<h3>你无权访问!</h3>";
}
?>