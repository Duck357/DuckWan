<?php
session_start(); // 启动会话

// 销毁会话数据
$_SESSION = array();
session_destroy();

// 重定向到登录页面
header('Location: index.php');
exit;
?>