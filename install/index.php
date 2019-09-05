<?php
session_start();
if (isset($_SESSION["step"]) && !empty($_SESSION["step"])) {
  $nStep = $_SESSION["step"];
} else {
  $nStep = 0;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>开始文档</title>
  <link rel="stylesheet" href="/include/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/include/css/icons.css">
  <link rel="stylesheet" href="/include/css/shared.css">
  <link rel="stylesheet" href="/include/css/install.css">
</head>

<body>
  <!-- #setupModal -->
  <div class="modal fade" id="setupModal" tabindex="-1" role="dialog" aria-labelledby="setupModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
          <h4 class="modal-title" id="setupModalLabel">Modal title</h4>
        </div>
        <div class="modal-body">

          <?php
          for ($i = 0; $i < 50; $i++) {
            echo ($i + 1) . "<br/>";
          }
          ?>
        </div>
        <div class="modal-footer">
          <button id="btnCancel" type="button" class="btn btn-default">取消</button>
          <button id="btnPrev" type="button" class="btn btn-step <?php if (!$nStep) {
                                                                    echo 'hidden';
                                                                  } ?>">上一步</button>
          <button id="btnNext" type="button" class="btn btn-step">下一步</button>
        </div>
      </div>
    </div>
  </div>
  <!-- #setupModal end -->

  
</body>
<script src="/include/jquery/jquery.min.js"></script>
<script src="/include/bootstrap/js/bootstrap.min.js"></script>
<script src="/include/js/shared.js"></script>
<script>
  $(function() {
    var step = <?php echo $nStep; ?>;
    $("#setupModal").modal({
      backdrop: 'static',
      keyboard: false
    });

    $("#btnCancel").off("click").on("click", function() {
      if (confirm("确定要取消吗？")) {
        window.close();
      }
    });

    $("#btnNext").off("click").on("click", function() {
      step = <?php echo $nStep = $_SESSION["step"] += 1; ?>;
      setCookie("step", step);
      console.log(step);

      if (step) {
        $("#btnPrev").removeClass("hidden");
      }

      $.ajax({
        url: "/install/step.php",
        type: "POST",
        data: "step=1",
        processData: false,
        // contentType: false,
        // dataType: "json",
        success: function(result) {
          console.log(result);
          $(".modal-body").html(result);
        },
        error: function(err) {}
      });
    });
  });
</script>

</html>