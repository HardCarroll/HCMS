(function($) {
  $.fn.extend({
    fileTree: function (options) {
      // 1, 检查参数合法性
      if (!isValid(options)) {
        return $(this);
      }

      // 2, 重构参数
      var opt = $.extend({}, defaults, options);

      // 3, return让插件得以链式调用
      return $(this).each(function () {
        // console.log(opt);
        // $(this).loadFile(opt).refreshTree(opt);
        // refreshDomTree(opt.scanPath);
        $(this).loadFile(opt).refreshTree(opt);
      });
    },
    refreshTree: function(options) {
      // 重新生成DOM树形结构

      // 1, 检查参数合法性
      if (!isValid(options)) {
        return $(this);
      }

      // 2, 重构参数
      var opt = $.extend({}, defaults, options);

      // 3, return让插件得以链式调用
      return $(this).each(function() {
        $.ajax({
          url: "/plugin/fileTree/fileTree.php",
          type: "POST",
          data: "path=" + opt.scanPath,
          // contentType: false,
          processData: false,
          dataType: "json",
          success: function (result) {
            // console.log(result);
            if (result.err_no) {
              console.log(result.err_code);
            }
            else {
              // 判断是否有#fileTree元素节点, 没有则先添加#fileTree节点
              if (!$("body").find("#fileTree").length) {
                var dlg = $("<div id='fileTree'><div class='content'><div class='content-head'><span class='title'>File Tree Dialog</span><span class='close glyphicon glyphicon-remove'></span></div><div class='content-body'><div class='file-list'></div><div class='v-seperator'></div><div class='file-thumb'></div></div><div class='content-foot'><input type='button' value='Refresh' id='refresh'><label>当前位置：</label><div class='pathRoute'></div></div></div></div>");

                dlg.appendTo("body").find(".glyphicon-remove").click(function () {
                  $("#fileTree").remove();
                });

                var routeArray = opt.scanPath.split("/");
                for (var i in routeArray) {
                  if (routeArray[i]) {
                    dlg.find(".pathRoute").append("<span>" + routeArray[i] + "</span>");
                  }
                }
              }

              // 生成DOM树形结构
              createDomTree(result.err_code, $("#fileTree").find(".file-list"));

              // 让根节点处于展开状态
              $("#fileTree").find(".file-list").children().eq(0).addClass("on");

              // 对子节点注册点击事件
              $("#fileTree").find(".item-head").off("click").on("click", function (e) {
                e.stopPropagation();
                e.preventDefault();
                if ($(this).next().length) {
                  // if ($(this).attr("data-type") === "folder") {
                  $(this).parent().toggleClass("on");
                  $(".pathRoute").html("");
                  var pathArray = $(this).attr("data-path").split("/");
                  for (var i in pathArray) {
                    if (pathArray[i]) {
                      $(".pathRoute").append("<span>" + pathArray[i] + "</span>");
                    }
                  }
                }
                else {
                  console.log($(this).attr("data-type"));
                }
              });
            }
          },
          error: function (err) {
            console.log("fail: " + err);
          }
        });
      });
    },
    loadFile: function(options) {
      // 动态加载文件

      // 1, 检查参数合法性
      if (!isValid(options)) {
        return $(this);
      }

      // 2, 重构参数
      var opt = $.extend({}, defaults, options);

      // 3, return让插件得以链式调用
      return $(this).each(function() {
        if (!opt.loadFile) {
          console.log("参数格式为： {loadFile: 文件路径}");
          // return $(this);
        }
        else {
          // console.log(opt);
          if ("string" === typeof(opt.loadFile)) {
            var ext = opt.loadFile.substring(opt.loadFile.lastIndexOf("."));
            if (".css" === ext && !$("head").find("link[href='" + opt.loadFile + "']").length) {
              $("<link>").attr({ "href": opt.loadFile, "rel": "stylesheet", "type": "text/css" }).appendTo("head");
            }
            if (".js" === ext && !$("head").find("script[src='" + opt.loadFile + "']").length) {
              $("<script></script>").attr({ "src": opt.loadFile, "type": "text/javascript"}).appendTo("head");
            }
          }
          else if ("object" === typeof(opt.loadFile)) {
            for (var k in opt.loadFile) {
              var fp = opt.loadFile[k];
              var ext = fp.substring(fp.lastIndexOf("."));
              if (".css" === ext && !$("head").find("link[href='" + fp + "']").length) {
                $("<link>").attr({ "href": fp, "rel": "stylesheet", "type": "text/css" }).appendTo("head");
              }
              if (".js" === ext && !$("head").find("script[src='" + fp + "']").length) {
                $("<script></script>").attr({ "src": fp, "type": "text/javascript"}).appendTo("head");
              }
            }
          }
        }
      });
    },
    debug: function(options) {
      return $(this).each(function() {
        console.log("call in plugin");
      });
    }
  });

  // 默认参数
  var defaults = {loadFile: "/plugin/fileTree/fileTree.css", scanPath: "/upload"};

  // 私有方法，不能被外部访问
  // 检查参数合法性
  function isValid(options) {
    if (!options || (options && "object" === typeof(options))) {
      return true;
    }
    else {
      alert("the parameter is not valid, please check it!");
      return false;
    }
  }

  // 生成DOM树结构
  function createDomTree(data, parentNode = $("#fileTree .file-list")) {
    var cNode = $('<div class="tree-item"></div>');
    parentNode.append(cNode);
    var cHead = $('<div class="item-head"><span class="glyphicon"></span><span class="item-name"></span></div>');
    cHead.attr({
      "data-path": data.path,
      "data-type": data.type,
      "title": data.name
    }).find("span.item-name").html(data.name);
    cNode.append(cHead);

    if ("object" === typeof(data.sub_file)) {
      cHead.find("span.glyphicon").addClass("glyphicon-folder");
      var cBody = $('<div class="item-body"></div>');
      cNode.append(cBody);

      for (var k in data.sub_file) {
        createDomTree(data.sub_file[k], cBody);
      }
    } else {
      cHead.find("span.glyphicon").addClass("glyphicon-file");
    }
  }

})(jQuery);