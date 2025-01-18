<?php
session_start();

// 验证 token 参数
$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);
if (empty($token)) {
    echo '无效的下载请求';
    exit;
}

// 检查 token 是否存在且未过期
if (!isset($_SESSION['download_token'][$token])) {
    echo '无效的或已过期的 token';
    exit;
}

// 获取 token 关联的数据
$tokenData = $_SESSION['download_token'][$token];
if ($tokenData['expire'] < time()) {
    unset($_SESSION['download_token'][$token]); // 删除过期的 token
    echo '下载链接已过期';
    exit;
}

$filePath = $tokenData['file_path'];
if (!file_exists($filePath)) {
    echo '文件不存在';
    exit;
}

// 清理 token，避免重复使用
unset($_SESSION['download_token'][$token]);

// 设置文件下载头并输出文件内容
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
header('Content-Length: ' . filesize($filePath));
readfile($filePath);
exit;
?>
