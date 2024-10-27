<?php
function deleteDirectory($dirPath) {
    if (!is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = array_diff(scandir($dirPath), array('.', '..'));
    foreach ($files as $file) {
        if (is_dir($dirPath . $file)) {
            deleteDirectory($dirPath . $file);
        } else {
            unlink($dirPath . $file);
        }
    }
    return rmdir($dirPath);
}

// 检查是否有数据被提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 初始化错误消息变量
    $error = "无错误";

    // 获取表单数据
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // 检查密码是否正确
    if ($password === 12345) {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : '';
        $data = json_decode(file_get_contents('json'), true);

        // 删除指定ID的元素
        unset($data[$id]);
        
        if(file_exists('file/'.$id.'/')){
            deleteDirectory('file/'.$id.'/');
        }

        // 重新构建数组，确保键名是连续的
        $newData = array();
        $sum = $data['sum'];
        for ($i = 1; $i <= $sum; $i++) {
            if ($i == $id) {
                continue; // 跳过要删除的ID
            }
            if ($i > $id) {
                $newData[$i - 1] = $data[$i];
                $newData[$i - 1]['id'] = $data[$i]['id']-1;
                if(file_exists('file/'.$i.'/')){
                    rename('file/'.$i.'/', 'file/'.($i-1).'/');
                }
            } else {
                $newData[$i] = $data[$i];
            }
        }
        $newData['sum'] = $sum - 1; // 更新sum的值

        // 输出结果
        echo "状态: " . htmlspecialchars($error) . "<br>";
        file_put_contents('json',json_encode($newData, JSON_UNESCAPED_UNICODE));
        header('root.php');
        exit();
    } else {
        $error = "密码错误";
        echo "状态: " . htmlspecialchars($error);
    }
}
?>