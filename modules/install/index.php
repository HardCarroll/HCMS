<?php
session_start();
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
        <span class="step-item done">Step_1</span>
        <span class="step-item">Step_2</span>
        <span class="step-item">Step_3</span>
        <span class="step-item">Step_4</span>
      </div>
      <div class="step-content">
        <!-- <?php echo file_get_contents("./step1"); ?> -->
        <div class="input-group">
          <span class="input-group-addon">数据库账号</span>
          <input id="inDBAccount" type="text" class="form-control">
        </div>
        <div class="input-group">
          <span class="input-group-addon">数据库密码</span>
          <input id="inDBPassword" type="text" class="form-control">
        </div>
        <div class="input-group">
          <span class="input-group-addon">数据库地址</span>
          <input id="inDBServer" type="text" class="form-control" value="localhost">
        </div>
        <div class="input-group">
          <span class="input-group-addon">数据库名称</span>
          <input id="inDBName" type="text" class="form-control">
        </div>
        <div class="input-group">
          <span class="input-group-addon">数据表前缀</span>
          <input id="inDBPrefix" type="text" class="form-control">
        </div>
        <div class="return-msg"></div>
      </div>
    </div>
    <div class="install-foot">
      <span class="btn btn-default btn-prev hidden">Prev</span>
      <span class="btn btn-default btn-next">Next</span>
      <span class="btn btn-default btn-done hidden">Done</span>
    </div>
  </div>
</body>

<script src="/include/jquery/jquery.min.js"></script>
<script src="/include/bootstrap/js/bootstrap.min.js"></script>
<script src="./install.js"></script>

</html>