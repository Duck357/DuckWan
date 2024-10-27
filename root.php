<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="image/icon.ico" />
<title>后台管理系统</title>
<!-- 引入Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    font-family: 'Arial', sans-serif;
  }
  .sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    padding: 20px 0;
    width: 250px;
    background: #333;
  }
  .sidebar .nav {
    flex-direction: column;
  }
  .sidebar .nav-link {
    color: #fff;
    padding: 10px 20px;
    border-radius: 0;
  }
  .sidebar .nav-link:hover,
  .sidebar .nav-link.active {
    background: #555;
  }
  .main-content {
    margin-left: 250px;
    padding: 20px;
  }
  .header {
    padding: 20px;
    background: #f8f9fa;
    border-bottom: 1px solid #e7e7e7;
  }
  .tab-content {
    margin-top: 20px;
  }
  .tab-pane {
    display: none;
  }
  .tab-pane.active {
    display: block;
  }
</style>
</head>
<body>

<?php
$showForm = true;
    
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取用户输入的数据
    $userInput = isset($_POST['userInput']) ? $_POST['userInput'] : '';
    // 这里可以处理用户输入的数据
    $passwoed = 12345; //这里是后台密码
    if(htmlspecialchars($userInput) === $password){
    $showForm =false;
        $data = json_decode(file_get_contents('json'),true);
      echo '<div class="sidebar">
            <nav class="nav flex-column">
              <a class="nav-link active" href="#dashboard" data-toggle="tab">仪表板</a>
              <a class="nav-link" href="#orders" data-toggle="tab">文章管理</a>
              <a class="nav-link" href="#users" data-toggle="tab">用户公告管理</a>
              <a class="nav-link" href="#settings" data-toggle="tab">设置</a>
            </nav>
          </div>
          
          <div class="main-content">
            <div class="header">
              <h2>后台管理系统</h2>
            </div>
            <div class="tab-content">
              <div class="tab-pane active" id="dashboard">
                <h3>仪表板</h3>
                <p>欢迎来到后台管理系统。</p>
              </div>
              <div class="tab-pane" id="orders">
                <h3>文章管理</h3>
                <p>这里是文章管理的内容。</p>';
                echo "<h2>当前网站总文章数量".$data["sum"]."</h2>";
                foreach (array_reverse($data) as $key => $article) {
                    if ($key !== 'sum' && $key !== 'file') {
                        echo "<h5>" . htmlspecialchars($article['title']) . " - 作者:" . htmlspecialchars($article['user']) . " - id" . htmlspecialchars($article['id']) . " - 阅读量:" . htmlspecialchars($article['read']) . " - " . htmlspecialchars($article['time']) . "</h5><br>";
                    }
                }
                echo'<form action="edit.php" method="post">
                        <label for="id">文章ID</label>
                        <input type="number" id="id" name="id" min="1" required>
                        <label for="read">更改阅读量</label>
                        <input type="number" id="read" name="read" min="0" required> 
                        <label for="password">管理员密码</label>
                        <input type="password" id="password" name="password" required>
                        <input type="submit" value="修改">
                    </form>';
                echo'<form action="delta.php" method="post">
                        <label for="id">文章ID</label>
                        <input type="number" id="id" name="id" min="1" required>
                        <label for="password">管理员密码</label>
                        <input type="password" id="password" name="password" required>
                        <input type="submit" value="删除⚠️">
                    </form>';
               echo '</div>
              <div class="tab-pane" id="users">
                <h3>用户公告管理</h3>
                <p>这里是用户公告管理的内容。</p>
                <form action="newtext.php" method="post">
                        <label for="info">公告名称</label><br>
                        <input type="text" id="info" name="info" required><br>
                        <label for="name">发布人</label><br>
                        <input type="text" id="name" name="name" required><br>
                        <label for="text">内容</label><br>
                        <textarea type="text" id="text" name="text" required></textarea><br>
                        <label for="password">管理员密码</label><br>
                        <input type="password" id="password" name="password" required><br>
                        <input type="submit" value="修改">
                </form>
              </div>
              <div class="tab-pane" id="settings">
                <h3>设置</h3>
                <p>这里是设置的内容。</p>
              </div>
            </div>
          </div>';
      }
  }
?>

<?php if ($showForm): ?>
<form action="" method="post">
  <label for="userInput">请输入密码:</label>
  <input type="password" id="userInput" name="userInput">
  <input type="submit" value="提交">
</form>
<?php endif; ?>

<!-- 引入jQuery和Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
  // JavaScript代码可以放在这里
  // 例如，为侧边导航添加active状态
  $(document).ready(function() {
    $('.nav-link').click(function(e) {
      e.preventDefault();
      $('.nav-link').removeClass('active');
      $(this).addClass('active');
      var href = $(this).attr('href');
      $(href).addClass('active').siblings('.tab-pane').removeClass('active');
    });
  });
</script>
</body>
</html>