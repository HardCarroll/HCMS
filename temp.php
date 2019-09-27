<!DOCTYPE html>
<html lang="zh-CN" onselectstart="return false;">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Temp Document</title>
  <link rel="stylesheet" href="/include/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/include/css/icons.css">
  <style>
    .wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 15px;
      position: relative;
      box-shadow: 0 0 6px #333;
      margin-top: 50px;
    }

    .input-box .input-group+.input-group {
      margin-top: 5px;
    }

    .input-box .input-group .input-group-addon,
    .input-box .input-group .form-control {
      border-radius: 0;
    }

    .button-box {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .button-box .btn+.btn {
      margin-top: 5px;
    }

    #fileTree {
      cursor: default;
      /* display: none; */
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 10000;
      background-color: rgba(0, 0, 0, 0.3);
    }

    #fileTree .content {
      width: 600px;
      height: 600px;
      position: relative;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #FFF;
      box-shadow: 0 0 6px 0 #333;
      border-radius: 6px;
      display: flex;
      flex-direction: column;
    }

    #fileTree .content .content-head {
      height: 40px;
      line-height: 40px;
      text-align: center;
      font-size: 20px;
      font-weight: 700;
    }

    #fileTree .content .content-head .glyphicon-remove {
      font-size: 16px;
      font-weight: normal;
      float: right;
      width: 30px;
      height: 40px;
      line-height: 40px;
      cursor: pointer;
    }

    #fileTree .content .content-body {
      border-top: 1px solid #666;
      border-bottom: 1px solid #666;
      flex: 1;
      overflow: auto;
    }

    #fileTree .content .content-body .frame {
      border: 5px solid #FFF;
      background-color: #EEE;
      width: 100%;
      height: 100%;
      padding-right: 17px;
      overflow-x: hidden;
      overflow-y: scroll;
      word-break: break-all;
      text-align: center;
    }

    .frame .file-list .list-item {
      padding: 10px 0;
      cursor: pointer;
    }

    .frame .file-list .list-item .item-icon {
      display: block;
      font-size: 50px;
    }

    #fileTree .content .content-foot {
      height: 40px;
      padding: 0 10px;
    }

    #fileTree .content .content-foot label {
      vertical-align: top;
      height: 100%;
      line-height: 40px;
      margin-bottom: 0;
    }

    .pathRoute {
      display: inline-block;
      padding-left: 10px;
      height: 40px;
      line-height: 40px;
      font-weight: 700;
      position: relative;
    }

    .pathRoute::before {
      content: "/\00a0";
      width: 10px;
      height: 100%;
      text-align: center;
      position: absolute;
      top: 0;
      left: 0px;
    }

    .pathRoute span {
      display: inline-block;
      height: 100%;
      padding-right: 10px;
      position: relative;
    }

    .pathRoute span::after {
      content: "/\00a0";
      width: 20px;
      height: 100%;
      text-align: center;
      position: absolute;
      top: 0;
      right: -10px;
    }

    .tree-list {
      width: 300px;
      height: 600px;
      overflow: auto;
      background-color: lightgray;
      border: 3px solid gray;
      padding: 5px;
      margin: 50px auto;
      user-select: none;
    }

    .tree-item {
      position: relative;
      border: 1px solid;
    }

    .tree-item+.tree-item {
      margin-top: 5px;
    }

    .item-head {
      background-color: #eaeaea;
      padding: 5px;
      cursor: pointer;
    }

    .item-head>.item-name {
      margin-left: 5px;
    }

    .item-head>.glyphicon-folder::before {
      content: "\e117";
    }

    .item-body {
      padding: 5px;
      display: none;
      opacity: 0;
      transition: all 0.6s;
    }

    .tree-item.on>.item-head>.glyphicon-folder::before {
      content: "\e118";
    }

    .tree-item.on>.item-body {
      display: block;
      opacity: 1;
    }

    .text-ellipsis {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4 input-box">
          <div class="input-group">
            <label for="inJsonPath" class="input-group-addon">数据文件路径</label>
            <input type='text' spellcheck='false' class="form-control" id='inJsonPath' placeholder='path of source file' value="/upload/">
          </div>
          <div class="input-group">
            <label for="inTemplatePath" class="input-group-addon">模板文件路径</label>
            <input type='text' spellcheck='false' class="form-control" id='inTemplatePath' placeholder='path of template file' value="/template/temp_case.php">
          </div>
        </div>
        <div class="col-md-2 button-box">
          <div class="btn btn-default" id="btnFileTree">Button1</div>
          <div class="btn btn-default" id="btn">Button2</div>
        </div>
      </div>
    </div>
  </div>

  <?php

  // echo json_encode(fileTree(__DIR__), 320);
  // echo "<br>".__DIR__."<br>";
  ?>

  <!-- <div id='fileTree'>
    <div class='content'>
      <div class='content-head'>
        <span class='title'>File Tree Dialog</span>
        <span class='close glyphicon glyphicon-remove'></span>
      </div>
      <div class='content-body'>
        <div class='frame container-fluid'>
          <div class='file-list row'>
            <div class='list-item col-xs-3'>
              <span class='item-icon glyphicon glyphicon-folder-close'></span>
              <span class='item-title'>about</span>
            </div>
            <div class='list-item col-xs-3'>
              <span class='item-icon glyphicon glyphicon-folder-close'></span>
              <span class='item-title'>advantage</span>
            </div>
            <div class='list-item col-xs-3'>
              <span class='item-icon glyphicon glyphicon-folder-close'></span>
              <span class='item-title'>budget</span>
            </div>
            <div class='list-item col-xs-3'>
              <span class='item-icon glyphicon glyphicon-file'></span>
              <span class='item-title'>index.php</span>
            </div>
            <div class='list-item col-xs-3'>
              <span class='item-icon glyphicon glyphicon-file'></span>
              <span class='item-title'>temp.php</span>
            </div>
          </div>
        </div>
      </div>
      <div class='content-foot'>
        <label>当前位置：</label>
        <div class="pathRoute">
          <span>about</span>
          <span>upload</span>
        </div>
      </div>
    </div> -->
    <!-- <iframe src="/player.html" frameborder="0"></iframe> -->

</body>

</html>
<script src="/include/jquery/jquery.min.js"></script>
<script src="/include/bootstrap/js/bootstrap.min.js"></script>
<script>
  $(function() {
    $(".form-control").on("focus", function() {
      // console.log("focus in " + $(this).attr("id"));
      $(this).select();
    });

    $(".item-head").off("click").on("click", function(e) {
      e.stopPropagation();
      e.preventDefault();
      if ($(this).next().length) {
        $(this).parent().toggleClass("on");
      } else {
        console.log($(this).html());
      }

    });

    (function($) {
      $.fn.extend({
        hello: function(options) {
          if(!isValid(options)) {
            return $(this);
          }
          var opt = $.extend({}, defaults, options);
          return $(this).each(function() {
            console.log("hello, " + opt.name);
          });
        },
        world: function(options) {
          if(!isValid(options)) {
            return $(this);
          }
          var opt = $.extend({}, defaults, options);
          return $(this).each(function() {
            console.log("I am " + opt.age);
          });
        },
        logParam: function(options) {
          if(!isValid(options)) {
            return $(this);
          }
          var opt = $.extend({}, defaults, options);
          return $(this).each(function() {
            console.log(opt);
          });
        }
      });

      // 默认参数
      var defaults = {name: "Jack", age: 18, sex: "male"};

      // 私有方法，不能被外部访问
      function isValid(options) {
        if(!options || (options && "object" === typeof(options))) {
          return true;
        }
        else {
          console.log("the parameter is not valid, please check it!");
          return false;
        }
      }
    })(jQuery);

    $("#btn").click(function() {
      var fmd = new FormData();
      fmd.append("token", "fileDomTree");
      var data = {ajaxData: {url: "/ajax/url", type: "POST", dataType: "json", data: fmd}, dlgFrame: "string test"};
      $(this).hello({name: "Rose"}).world(16).logParam(data);
    });


    $("#btnFileTree").on("click", function() {
      var fmd = new FormData();
      fmd.append("token", "fileTree");
      var val = $("#inJsonPath").val();
      if (!val) {
        val = "/";
      }
      fmd.append("filePath", val);

      if (!$("body").find("#fileTree").length) {
        var dlg = $("<div id='fileTree'><div class='content'><div class='content-head'><span class='title'>File Tree Dialog</span><span class='close glyphicon glyphicon-remove'></span></div><div class='content-body'></div><div class='content-foot'><label>当前位置：</label><div class='pathRoute'></div></div></div></div>");
        var routeArray = val.split("/");
        for (var i in routeArray) {
          if (routeArray[i]) {
            dlg.find(".pathRoute").append("<span>" + routeArray[i] + "</span>");
          }
        }
        $("body").append(dlg);
      }
      $("#fileTree").find(".glyphicon-remove").click(function() {
        $("#fileTree").remove();
      });

      $.ajax({
        url: "/include/php/handle.php",
        type: "POST",
        data: fmd,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(result) {
          // console.log(result);
          if(result.err_no) {
            console.log(result.err_code);
          }
          else {
            fileDomTree(result, $("#fileTree").find(".content-body"));
          }
        },
        error: function(err) {
          console.log("fail: " + err);
        }
      });

    });

    // var data = JSON.parse('{"name":"upload","path":"/upload/","sub_file":[{"name":"2019082601","path":"/upload/2019082601","sub_file":[{"name":"2019082601.json","path":"/upload/2019082601/2019082601.json","sub_file":""},{"name":"201908260101.jpg","path":"/upload/2019082601/201908260101.jpg","sub_file":""},{"name":"201908260102.jpg","path":"/upload/2019082601/201908260102.jpg","sub_file":""},{"name":"201908260103.jpg","path":"/upload/2019082601/201908260103.jpg","sub_file":""},{"name":"201908260104.jpg","path":"/upload/2019082601/201908260104.jpg","sub_file":""}]}]}');

    function fileDomTree(data, parentNode = $("body")) {

      var cNode = $('<div class="tree-item"></div>');
      parentNode.append(cNode);
      var cHead = $('<div class="item-head"><span class="glyphicon"></span><span class="item-name"></span></div>');
      cHead.attr({
        "data-path": data.path
      }).find("span.item-name").html(data.name);
      cNode.append(cHead);

      if ("object" === typeof(data.sub_file)) {

        cHead.find("span.glyphicon").addClass("glyphicon-folder");
        var cBody = $('<div class="item-body"></div>');
        cNode.append(cBody);

        for (var k in data.sub_file) {
          fileDomTree(data.sub_file[k], cBody);
        }
      } else {
        cHead.find("span.glyphicon").addClass("glyphicon-file");
      }

      $(".item-head").off("click").on("click", function(e) {
        e.stopPropagation();
        e.preventDefault();
        if ($(this).next().length) {
          $(this).parent().toggleClass("on");
          $(".pathRoute").html("");
          var pathArray = $(this).attr("data-path").split("/");
          for (var i in pathArray) {
            if (pathArray[i]) {
              $(".pathRoute").append("<span>" + pathArray[i] + "</span>");
            }
          }
        } else {
          console.log($(this).html());
        }

      });

    }

  });
</script>