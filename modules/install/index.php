<?php
session_start();
if(isset($_SESSION["bInstalled"]) && !empty($_SESSION["bInstalled"]) && file_exists($_SERVER["DOCUMENT_ROOT"]."/modules/install/.installed.lock")) {
  header("location: /");
}
$step = 1;
if(isset($_SESSION["step"]) && !empty($_SESSION["step"])) {
  $step = $_SESSION["step"];
}
if(isset($_SESSION["count_steps"]) && !empty($_SESSION["count_steps"])) {
  $count_steps = $_SESSION["count_steps"];
}
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
        <span class="step-item active">第一步</span>
        <span class="step-item">第二步</span>
        <span class="step-item">第三步</span>
        <span class="step-item">第四步</span>
      </div>
      <div class="step-content">
        <?php echo file_get_contents("./step".$step); ?>
      </div>
    </div>
    <div class="install-foot">
      <span class="btn btn-primary btn-prev <?php if($step === 1) echo "hidden"; ?>">上一步</span>
      <span class="btn btn-primary btn-next <?php if($step === $count_steps) echo "hidden"; ?>">下一步</span>
      <span class="btn btn-success btn-done <?php if($step !== $count_steps) echo "hidden"; ?>">完成</span>
      <span class="btn btn-default btn-debug">Debug</span>
    </div>
  </div>
</body>

<script src="/include/jquery/jquery.min.js"></script>
<script src="/include/bootstrap/js/bootstrap.min.js"></script>
<script src="./install.js"></script>
<script>
  $(".btn-debug").click(function() {
    // $(this).next();
  });
  
  var step = <?php echo $step; ?>;
  $(".step-item").eq(step-1).addClass("active").prevAll().removeClass("active").addClass("done");

  $(".btn-prev").off("click").on("click", function() {
    step = $(this).install({step: step, token: "prev"});
  });

  $(".btn-next").off("click").on("click", function() {
    step = $(this).install({step: step, token: "next"});
  });

  $(".btn-done").off("click").on("click", function() {
    $(this).install({step: step, token: "done"});
  });
</script>

</html>