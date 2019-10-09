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
        // $(this).refreshTree(opt);
        loadFile(opt);
        refreshTree(opt);

        // 添加工具栏
        if(opt.toolBar) {
          console.log("addToolBar()");
        }
      });
    },
    debug: function(options) {
      var opt = $.extend({}, defaults, options);
      return $(this).each(function() {
        console.log("call in plugin");
        logout(opt);
      });
    }
  });

  // 默认参数
  var defaults = {loadFile: "/plugin/fileTree/fileTree.css", scanPath: "/upload", toolBar: false};

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
    var cHead = $('<div class="item-head"><span class="glyphicon"></span><span class="item-name"></span><span class="glyphicon"></span></div>');
    cHead.attr({
      "data-path": data.path,
      "data-type": data.type,
      "title": data.name
    }).find("span.item-name").html(data.name);
    cNode.append(cHead);

    if ("object" === typeof(data.sub_file)) {
      cHead.find("span.glyphicon").eq(0).addClass("glyphicon-folder");
      cHead.find("span.glyphicon").eq(1).addClass("glyphicon-menu");
      var cBody = $('<div class="item-body"></div>');
      cNode.append(cBody);

      for (var k in data.sub_file) {
        createDomTree(data.sub_file[k], cBody);
      }
    } else {
      cHead.find("span.glyphicon").eq(0).addClass("glyphicon-file");
    }
  }

  function refreshTree(opt) {
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
          // alert(result.err_code);
        }
        else {
          // 判断是否有#fileTree元素节点, 没有则先添加#fileTree节点
          if (!$("body").find("#fileTree").length) {
            var dlg = $("<div id='fileTree'><div class='content'><div class='content-head'><span class='title'>File Tree Dialog</span><span class='close glyphicon glyphicon-remove'></span></div><div class='content-address'><label>当前位置：</label><div class='pathRoute'></div></div><div class='content-body'><div class='file-list'></div><div class='v-seperator'></div><div class='file-thumb'></div></div><div class='content-foot'></div></div></div>");

            // 对话框关闭按钮
            dlg.appendTo("body").find(".glyphicon-remove").off("click").on("click", function () {
              $("#fileTree").remove();
            });

            dlg.find("#refresh").off("click").on("click", function() {
              console.log("refreshTree()");
            });

            var routeArray = opt.scanPath.split("/");
            for (var i in routeArray) {
              if (routeArray[i]) {
                dlg.find(".pathRoute").append("<span>" + routeArray[i] + "</span>");
              }
            }
          }

          $("#fileTree").find(".file-list").empty();

          // 生成左侧DOM树形结构
          createDomTree(result.err_code, $("#fileTree").find(".file-list"));

          // 让根节点处于展开状态
          $("#fileTree").find(".file-list").children(0).addClass("on");

          // 生成右侧DOM缩略图
          createDomThumb($("#fileTree").find(".file-list").children(0).children("[class='item-head']").attr("data-path"));

          // 对子节点注册点击事件
          $("#fileTree").find(".item-head").off("click").on("click", function (e) {
            e.stopPropagation();
            e.preventDefault();
            if ($(this).attr("data-type") === "folder") {
              // $(".pathRoute").empty();
              // var pathArray = $(this).attr("data-path").split("/");
              // for (var i in pathArray) {
              //   if (pathArray[i]) {
              //     $(".pathRoute").append("<span>" + pathArray[i] + "</span>");
              //   }
              // }

              createDomThumb($(this).attr("data-path"));
            }
            else {
              console.log($(this).attr("title"));
            }
            
            $(".pathRoute").empty();
            var pathArray = $(this).attr("data-path").split("/");
            for (var i in pathArray) {
              if (pathArray[i]) {
                $(".pathRoute").append("<span>" + pathArray[i] + "</span>");
              }
            }
          });

          // 右侧小箭头点击事件
          $("#fileTree").find(".glyphicon-menu").off("click").on("click", function(e) {
            e.stopPropagation();
            e.preventDefault();
            $(this).parent().parent().toggleClass("on");
          });
        }
      },
      error: function (err) {
        console.log("fail: " + err);
      }
    }); // ajax end
  }

  function loadFile(opt) {
    // 动态加载文件
    if (!opt.loadFile) {
      console.log("参数格式为： {loadFile: 文件路径}");
      // return $(this);
    }
    else {
      // console.log(opt);
      if ("string" === typeof (opt.loadFile)) {
        var ext = opt.loadFile.substring(opt.loadFile.lastIndexOf("."));
        if (".css" === ext && !$("head").find("link[href='" + opt.loadFile + "']").length) {
          $("<link>").attr({ "href": opt.loadFile, "rel": "stylesheet", "type": "text/css" }).appendTo("head");
        }
        if (".js" === ext && !$("head").find("script[src='" + opt.loadFile + "']").length) {
          $("<script></script>").attr({ "src": opt.loadFile, "type": "text/javascript" }).appendTo("head");
        }
      }
      else if ("object" === typeof (opt.loadFile)) {
        for (var k in opt.loadFile) {
          var fp = opt.loadFile[k];
          var ext = fp.substring(fp.lastIndexOf("."));
          if (".css" === ext && !$("head").find("link[href='" + fp + "']").length) {
            $("<link>").attr({ "href": fp, "rel": "stylesheet", "type": "text/css" }).appendTo("head");
          }
          if (".js" === ext && !$("head").find("script[src='" + fp + "']").length) {
            $("<script></script>").attr({ "src": fp, "type": "text/javascript" }).appendTo("head");
          }
        }
      }
    }
  }
  
  function createDomThumb(path) {
    $("#fileTree").find(".file-thumb").empty();

    $("#fileTree .file-list").find("[data-path='"+path+"']").next().children().each(function() {
      // $("<div></div>").attr({
      //   "class": "thumb-item col-xs-3",
      //   "data-path": $(this).children("[class='item-head']").attr("data-path"),
      //   "title": $(this).children("[class='item-head']").attr("title")
      // }).append("<span class='glyphicon'></span>").append("<div class='thumb-name'>"+$(this).children("[class='item-head']").attr("title")+"</div>").appendTo("#fileTree .file-thumb");
      var ele = $("<div></div>").attr({
        "class": "thumb-item col-xs-3",
        "data-path": $(this).children("[class='item-head']").attr("data-path"),
        "data-type": $(this).children("[class='item-head']").attr("data-type"),
        "title": $(this).children("[class='item-head']").attr("title")
      });

      if($(this).children("[class='item-head']").attr("data-type") === "folder") {
        ele.append("<span class='glyphicon glyphicon-folder-close'></span>");
      }
      else {
        ele.append("<span class='glyphicon glyphicon-file'></span>");
      }

      ele.append("<div class='thumb-name'>"+$(this).children("[class='item-head']").attr("title")+"</div>").appendTo("#fileTree .file-thumb");
    });

    $("#fileTree .file-thumb .thumb-item").each(function() {
      $(this).off("click").on("click", function() {
        if($(this).attr("data-type") === "folder") {
          createDomThumb($(this).attr("data-path"));
          $("#fileTree .pathRoute").empty().append();

          // $(".pathRoute").empty();
          // var pathArray = $(this).attr("data-path").split("/");
          // for (var i in pathArray) {
          //   if (pathArray[i]) {
          //     $(".pathRoute").append("<span>" + pathArray[i] + "</span>");
          //   }
          // }
        }
        else {
          console.log($(this).attr("title"));
        }

        $(".pathRoute").empty();
        var pathArray = $(this).attr("data-path").split("/");
        for (var i in pathArray) {
          if (pathArray[i]) {
            $(".pathRoute").append("<span>" + pathArray[i] + "</span>");
          }
        }
      });
    });
  }

  function logout(params) {
    console.log(params);
    // console.log(defaults);
  }

})(jQuery);