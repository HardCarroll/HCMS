<?php
session_start();
if((!isset($_SESSION["bInstalled"]) || !$_SESSION["bInstalled"]) && !file_exists($_SERVER["DOCUMENT_ROOT"]."/modules/install/.installed.lock")) {
  header("location: /modules/install/");
}
?>
<!DOCTYPE html>
<html lang="zh-CN" onselectstart="return false;">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>HCMS DOCUMENT</title>
  <link rel="stylesheet" href="/include/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/plugin/fileTree/fileTree.css">
</head>
<body>
  <input type="button" value="BTN_TEST" id="btn">
  <input type="file" name="BTN_FILE" id="file" multiple>
  <input type="button" value="BTN_DEBUG" id="debug">
  <div class="imgs"></div>

  <!-- <div id="fileTree">
    <div class="content">
      <div class="content-head">
        <span class='title'>File Tree Dialog</span>
        <span class='close glyphicon glyphicon-remove'></span>
      </div>
      <div class="content-address">
        <div class="input-group">
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-arrow-left"></span>
          </div>
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-arrow-right"></span>
          </div>
          <div class="form-control">
            <span>file1</span>
            <span>file2</span>
            <span>file3</span>
            <span>file4</span>
            <span>file5</span>
            <span>file6</span>
          </div>
        </div>
      </div>
      <div class="content-body">
        <div class="file-list"></div>
        <div class='v-seperator'></div>
        <div class="file-thumb">
          <div class="thumb-item col-xs-3">
            <span class="glyphicon glyphicon-folder-close"></span>
            <div class="thumb-name">admin</div>
          </div>
          <div class="thumb-item col-xs-3">
            <span class="glyphicon glyphicon-folder-close"></span>
            <div class="thumb-name">include</div>
          </div>
          <div class="thumb-item col-xs-3">
            <span class="glyphicon glyphicon-folder-close"></span>
            <div class="thumb-name">admin</div>
          </div>
          <div class="thumb-item col-xs-3">
            <span class="glyphicon glyphicon-folder-close"></span>
            <div class="thumb-name">include</div>
          </div>
        </div>
      </div>
      <div class="content-foot">
        <div class="input-group">
          <span class="input-group-addon">文件名：</span>
          <input type="text" class="form-control">
          <span class="input-group-addon">选择</span>
          <span class="input-group-addon">取消</span>
        </div>
      </div>
    </div>
  </div> -->

  <script src="/include/jquery/jquery.min.js"></script>
  <script src="/include/bootstrap/js/bootstrap.min.js"></script>
  <script src="/plugin/fileTree/fileTree.js"></script>
  <script>
    $("#btn").click(function() {
      // $(this).fileTree();
      // $(this).fileTree({scanPath: "/../../../home"});
      $(this).fileTree({scanPath: "/"}).debug(function() {
        console.log('hello, ');
      });
    });

    $("#file").on("change", function() {
      $("div.imgs").empty();
      var files = $(this)[0].files;
      for (var i = 0; i < files.length; i++) {
        $("<img src='" + window.URL.createObjectURL(files[i]) + "'>").off("click").on("click", function() {
          $(this).addClass("hidden");
        }).appendTo("div.imgs");
      }
    });

    $("#debug").click(function() {
      var fmd = new FormData();
      var files = $("#file")[0].files;
      for(var i=0; i<files.length; i++) {
        fmd.append("files["+i+"]", files[i]);
      }
      $("div.imgs img[class='hidden']").each(function() {
        fmd.delete("files["+$(this).index()+"]");
      });

      $.ajax({
        url: "/test.php",
        type: "POST",
        data: fmd,
        contentType: false,
        dataType: "json",
        processData: false,
        success: function(result) {
          console.log(result);
        },
        error: function(err) {}
      });
    });
  </script>
</body>
</html>