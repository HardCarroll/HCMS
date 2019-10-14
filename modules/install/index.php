<?php
session_start();
$step = $_SESSION["step"];
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Install Page</title>
  <link rel="stylesheet" href="/include/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./install.css">
</head>

<body>
  <div class="install">
    <div class="install-head"></div>
    <div class="install-body">
      <div class="step-list">
        <span class="step-item done">第一步</span>
        <span class="step-item">第二步</span>
        <span class="step-item">第三步</span>
        <span class="step-item">第四步</span>
      </div>
      <div class="step-content">
        <?php echo file_get_contents("./step1"); ?>
      </div>
    </div>
    <div class="install-foot">
      <span class="btn btn-primary btn-prev hidden">上一步</span>
      <span class="btn btn-primary btn-next">下一步</span>
      <span class="btn btn-success btn-done hidden">完成</span>
      <span class="btn btn-default btn-debug">Debug</span>
    </div>
  </div>
</body>

<script src="/include/jquery/jquery.min.js"></script>
<script src="/include/bootstrap/js/bootstrap.min.js"></script>
<script src="./install.js"></script>
<script>
  // $(".btn-debug").click(function() {
  //   $(this).install({step: 2}).debug();
  // });
</script>

</html>