<?php
session_start();
if (isset($_SESSION["bInstalled"]) && !empty($_SESSION["bInstalled"]) && file_exists($_SERVER["DOCUMENT_ROOT"] . "/modules/install/.installed.lock")) {
  header("location: /");
}
$step = 1;
if (isset($_SESSION["step"]) && !empty($_SESSION["step"])) {
  $step = $_SESSION["step"];
}
if (isset($_SESSION["count_steps"]) && !empty($_SESSION["count_steps"])) {
  $count_steps = $_SESSION["count_steps"];
}

$_SESSION["install"]["0"] = array("step"=>1, "data"=>"first step");
$_SESSION["install"]["1"] = array("step"=>2, "data"=>"second step");
$_SESSION["install"]["2"] = array("step"=>3, "data"=>"third step");
$_SESSION["install"]["3"] = array("step"=>4, "data"=>"fouth step");

echo json_encode($_SESSION["install"][2], 320);

// print_r($_SESSION["install"]);
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
        <span class="step-list-item active">第一步</span>
        <span class="step-list-item">第二步</span>
        <span class="step-list-item">第三步</span>
        <span class="step-list-item">第四步</span>
      </div>
      <div class="step-table">
        <div class="step-table-item active">
          <div class="input-group">
            <span class="input-group-addon">数据库账号<b>*</b></span>
            <input id="inDBAccount" type="text" class="form-control" placeholder="请向网络空间服务商索取">
          </div>
          <div class="input-group">
            <span class="input-group-addon">数据库密码<b>*</b></span>
            <input id="inDBPassword" type="password" class="form-control" placeholder="请向网络空间服务商索取">
          </div>
          <div class="input-group">
            <span class="input-group-addon">数据库地址<b>*</b></span>
            <input id="inDBHost" type="text" class="form-control" value="localhost" placeholder="请向网络空间服务商索取">
          </div>
          <div class="input-group">
            <span class="input-group-addon">数据库名称<b>*</b></span>
            <input id="inDBName" type="text" class="form-control">
          </div>
          <div class="return-msg"></div>
        </div>
        <div class="step-table-item">
          <div class="input-group">
            <span class="input-group-addon">管理员账号<b>*</b></span>
            <input id="inAdminAccount" type="text" class="form-control" placeholder="后台超级管理员账号">
          </div>
          <div class="input-group">
            <span class="input-group-addon">管理员密码<b>*</b></span>
            <input id="inAdminPassword" type="password" class="form-control" placeholder="后台超级管理员密码">
          </div>
          <div class="input-group">
            <span class="input-group-addon">管理员密码<b>*</b></span>
            <input id="inAdminConfirm" type="password" class="form-control" placeholder="确认后台超级管理员密码">
          </div>
        </div>
        <div class="step-table-item">
          <p>page3: 1</p>
          <p>page3: 2</p>
          <p>page3: 3</p>
          <p>page3: 4</p>
          <p>page3: 5</p>
          <p>page3: 6</p>
          <p>page3: 7</p>
          <p>page3: 8</p>
          <p>page3: 9</p>
          <p>page3: 10</p>
          <p>page3: 11</p>
          <p>page3: 12</p>
          <p>page3: 13</p>
          <p>page3: 14</p>
          <p>page3: 15</p>
        </div>
        <div class="step-table-item">
          <p>page4: 1</p>
          <p>page4: 2</p>
          <p>page4: 3</p>
          <p>page4: 4</p>
          <p>page4: 5</p>
          <p>page4: 6</p>
          <p>page4: 7</p>
          <p>page4: 8</p>
          <p>page4: 9</p>
          <p>page4: 10</p>
          <p>page4: 11</p>
          <p>page4: 12</p>
          <p>page4: 13</p>
          <p>page4: 14</p>
          <p>page4: 15</p>
          <p>page4: 16</p>
          <p>page4: 17</p>
          <p>page4: 18</p>
          <p>page4: 19</p>
          <p>page4: 20</p>
        </div>
      </div>
    </div>
    <div class="install-foot">
      <span class="btn btn-primary btn-prev hidden<?php //if ($step === 1) echo "hidden"; ?>">上一步</span>
      <span class="btn btn-primary btn-next <?php //if ($step === $count_steps) echo "hidden"; ?>">下一步</span>
      <span class="btn btn-success btn-done hidden<?php //if ($step !== $count_steps) echo "hidden"; ?>">完成</span>
      <span class="btn btn-default btn-debug">Debug</span>
    </div>
  </div>
</body>

<script src="/include/jquery/jquery.min.js"></script>
<script src="/include/bootstrap/js/bootstrap.min.js"></script>
<script src="./install.js"></script>
</html>