$(function(){
  setSiteCookie();
  
  $(".layer").click(function(){
    // 解决sarfri浏览器不触发点击事件
  });

  // 点击空白处隐藏菜单栏
  $(document).on("click", function() {
    $(".navbar-collapse").removeClass("in");
  });
  $(".navbar-toggle").on("click", function(e) {
    e.stopPropagation();
    $(".navbar-collapse").removeClass("in");
    $($(this).attr("data-target")).toggleClass("in");
  });

  $("#logout").off("click").on("click", function(e) {
    e.stopPropagation();
    e.preventDefault();
    var fmd = new FormData();
    fmd.append("token", "logout");
    $.ajax({
      url: "/cms/include/php/handle.php",
      type: "POST",
      data: fmd,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(result) {
        if(!result.err_no) {
          window.location.href = result.href;
        }
        else {
          console.log(result);
        }
      },
      error: function(err) {
        console.log("fail: " + err);
      }
    });
  });

  $("#btn_ok").click(function(){
    if ($("#new-pwd1").val() !== $("#new-pwd2").val()) {
      $(".modal-footer>.tips").html("两次输入的密码不同，请重新输入！");
      $("#new-pwd1").focus();
    }
    else {
      var fmd = new FormData();
      var value = {username: $("#username").html(), oldPwd: $("#old-pwd").val(), newPwd1: $("#new-pwd1").val(), newPwd2: $("#new-pwd2").val()};
      fmd.append("token", "modifyPassword");
      fmd.append("data", JSON.stringify(value));
      $.ajax({
        url: "/cms/include/php/handle.php",
        type: "POST",
        data: fmd,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (result) {
          // var ret = JSON.parse(result);
          $(".modal-footer>.tips").html(result.err_code);
          if (result.err_no) {
            $("#old-pwd").focus();
          }
          else {
            setTimeout(function() {
              $("#modPwd").modal("hide");
              location.reload(true);
            }, 1600);
          }
          console.log(result);
        },
        error: function(msg) {
          console.log("fail: "+msg);
        }
      });
    }
  });

  $("#modPwd").on('hidden.bs.modal', function () {
    $("#old-pwd").val('');
    $("#new-pwd1").val('');
    $("#new-pwd2").val('');
    $(".modal-footer>.tips").html('');
  });

  // 左侧导航列表点击事件处理
  $(".nav-list>.list-item").off("click").on("click", function(e) {
    e.stopPropagation();
    e.preventDefault();
    if(!$(this).hasClass("active")) {
      window.location.href = $(this).attr("href");
    }
  });

  $(".slide-menu>li").on("click", function(e) {
    e.stopPropagation();
    e.preventDefault();
    $(this).addClass("active").siblings().removeClass("active");
    activateTab($(this));
  });

  regTabEvent();
});

/**
 * 设置网站信息的cookie
 */
function setSiteCookie() {
  var fmd = new FormData();
  fmd.append("token", "getSiteInfo");
  $.ajax({
    url: "/cms/include/php/handle.php",
    type: "POST",
    data: fmd,
    processData: false,
    contentType: false,   //数据为formData时必须定义此项
    dataType: "json",     //返回json格式数据
    success: function(result) {
      if(result) {
        setCookie("siteInfo", JSON.stringify(result));
      }
    },
    error: function(err) {
      console.log("fail: "+err);
    }
  }); // ajax_func
}

/**
 * 添加图片处理函数
 * @param {Object} target
 * @param {JSON} img
 */
function proc_addPictures(target, img) {
  // 添加图片节点
  $(target).parent().before('<div class="col-sm-4 col-md-3"><div class="thumbnail"><input type="file" style="display:none;"><img><div class="caption"><input type="text" placeholder="图片名称(如：效果图)" name="data-title"><input type="text" placeholder="图片alt属性(SEO关键词)" name="data-alt" value="'+JSON.parse(getCookie("siteInfo")).keywords+'"></div></div><span class="btn btn-remove glyphicon glyphicon-trash"></span></div>');
  // 更改图片路径
  $(target).parent().prev().find("img").attr("src", img.url);
  if(img.attr_title) {
    $(target).parent().prev().find("[name='data-title']").val(img.attr_title);
  }
  if(img.attr_alt) {
    $(target).parent().prev().find("[name='data-alt']").val(img.attr_alt);
  }
  // 注册图片删除按钮事件
  $(target).parent().prev().find("span.btn-remove").off("click").on("click", function(e) {
    e.stopPropagation();
    e.preventDefault();
    $(this).parent().remove();
  });
}

function activateTab(target) {
  // 如果此标签页没有打开，则创建并打开标签页
  if(!$("#pageTabs").find("li[href='" + $(target).attr("href") + "']").length) {
    var tabEle = '<li role="presentation" href="'+$(target).attr("href")+'">';
    tabEle += '<span class="pull-left '+$(target).find("span.title").prev().attr("class")+'"></span>';
    tabEle += '<span class="title">'+$(target).find("span.title").html()+'</span>';
    tabEle += '<span class="pull-right glyphicon glyphicon-remove tabRemove" role="button"></span>';
    tabEle += '</li>';
    $("#pageTabs").append(tabEle);
    regTabEvent();
  }
  // 激活当前标签页
  $("#pageTabs").find("li[href='" + $(target).attr("href") + "']").addClass("active").siblings().removeClass("active");
  $($(target).attr("href")).addClass("active").siblings().removeClass("active");

  // 更新左侧导航栏激活状态
  $(".nav-list").find('[href="' + $("#pageTabs").find(".active").attr("href") + '"]').addClass("active").siblings().removeClass("active");
  // $(".nav-list").find('[href="' + $(target).attr("href") + '"]').addClass("active").siblings().removeClass("active");

  if($(target).attr("href") === "#siteTab") {
    refresh_siteTab();
  }
  if($(target).attr("href") === "#caseTab") {
    refreshTabList({page: 1});
  }

  if($(target).attr("href") === "#uploadCase") {
    refreshTabContent({target: $("#uploadCase"), id: $("#uploadCase").attr("data-id")});
  }
  if($(target).attr("href") === "#uploadArticle") {
    refreshTabContent({target: $("#uploadArticle"), id: $("#uploadArticle").attr("data-id")});
  }
  if($(target).attr("href") === "#editTab") {
    $("#pageTabs>li[href='#editTab']").children().eq(0).addClass("glyphicon glyphicon-edit");
    $("#pageTabs>li[href='#editTab']").children().eq(1).html($(target).parent().parent().prev().children().eq(0).html());
    $("#pageTabs>li[href='#editTab']").attr("title", $(target).parent().parent().prev().children().eq(0).html());
    refreshTabContent({target: $("#editTab"), id: $("#editTab").attr("data-id")});
  }
}

function regTabEvent() {
  // 标签页关闭按钮点击事件处理函数
  $(".tabRemove").off("click").on("click", function(e) {
    e.stopPropagation();
    e.preventDefault();
    // 已激活标签页对应的标签页内容节点隐藏，即去掉active类
    if($(this).parent().hasClass("active")) {
      $($(this).parent().attr("href")).removeClass("active");

      if($(this).parent().next().length) {
        $($(this).parent().next().addClass("active").attr("href")).addClass("active");
      }
      else if($(this).parent().prev().length) {
        $($(this).parent().prev().addClass("active").attr("href")).addClass("active");
      }
    }

    // 删除当前标签页节点
    $(this).parent().remove();

    // 更新左侧导航栏激活状态
    $(".nav-list").find('[href="' + $("#pageTabs").find(".active").attr("href") + '"]').addClass("active").siblings().removeClass("active");
    
    if($("#pageTabs").find(".active").attr("href") === "#caseTab") {
      refreshTabList({page: 1});
    }
    if($("#pageTabs").find(".active").attr("href") === "#articleTab") {
      refreshTabList({page: 1});
    }

    // 清除data-id属性值
    $($(this).parent().attr("href")).attr("data-id", "");
  });

  // 标签页点击事件处理函数
  $("#pageTabs>li").off("click").on("click", function(e) {
    e.stopPropagation();
    e.preventDefault();
    activateTab($(this));
  });
}

/**
 * 分页列表实时生成，并注册点击事件
 * @param {JSON} argJson 
 */
function paginationList(argJson) {
  if (argJson.url) {
    var fmd = new FormData();
    fmd.append("token", argJson.token);
    fmd.append("handle", argJson.handle);
    if(argJson.rule) {
      fmd.append("rule", argJson.rule);
    }
    else {
      fmd.append("rule", "");
    }
    $.ajax({
      url: argJson.url,
      type: "POST",
      data: fmd,
      processData: false,
      contentType: false,   //数据为formData时必须定义此项
      context: argJson.target,
      success: function(result) {
        $(this).html("").html(result);
        paginationClick({object: $(this).find("li"), rule: argJson.rule});
      },
      error: function(err) {
        console.log("fail: "+err);
      }
    }); // ajax_func
  }
}

/**
 * 分页按钮点击处理函数
 * @param argJson
 * {
 *  object: DOM对象,
 *  rule: 查询数据库记录集条件,
 * }  
 * 
 */
function paginationClick(argJson) {
  argJson.object.each(function() {
    $(this).off("click").on("click", function() {
      var curIndex = 0;
      if ($(this).index() === 0) {
        // previous process 上一页处理
        if(!$(this).hasClass("disabled")) {
          $(this).parent().children().last().removeClass("disabled");
          $(this).parent().find(".active").removeClass("active").prev().addClass("active");
          if($(this).parent().find(".active").index() === $(this).parent().children().first().index()+1) {
            $(this).addClass("disabled");
          }
        }
        curIndex = $(this).parent().find(".active").index();
      }
      else if($(this).index() === $(this).parent().children().length-1){
        // next process 下一页处理
        if(!$(this).hasClass("disabled")) {
          $(this).parent().children().first().removeClass("disabled");
          $(this).parent().find(".active").removeClass("active").next().addClass("active");
          if($(this).parent().find(".active").index() === $(this).parent().children().last().index()-1) {
            $(this).addClass("disabled");
          }
        }
        curIndex = $(this).parent().find(".active").index();
      }
      else {
        // index process 索引标签处理
        $(this).addClass("active").siblings().removeClass("active");
        $(this).parent().children().first().removeClass("disabled");
        $(this).parent().children().last().removeClass("disabled");
        if($(this).index() === 1) {
          $(this).parent().children().first().addClass("disabled");
        }
        else if($(this).index() === $(this).parent().children().length-2) {
          $(this).parent().children().last().addClass("disabled");
        }
        curIndex = $(this).index();
      }

      refreshTabList({page: curIndex, rule: argJson.rule});
      
    }); // click_func
  }); // each_func
}

/**
 * 获取指定cookie键的值
 * @param key 指定要获取的cookie键
*/
function getCookie(key) {
  var arr,reg=new RegExp("(^| )"+key+"=([^;]*)(;|$)");
  if(arr=document.cookie.match(reg)) {
    return unescape(arr[2]);
  }
  else {
    return null;
  }
}

/**
 * 设置浏览器Cookie，默认不设置过期时间，浏览器关闭时清除
 * @param key cookie键
 * @param value cookie值
 * @param expires cookie过期时间，以秒为单位，默认为0，即不设置过期时间，浏览器关闭时清除
*/
function setCookie(key, value, expires=0) {
  var cookie = key + "=" + escape(value);
  if (expires) {
    var date = new Date();
    date.setTime(date.getTime()+expires*1000);
    cookie = cookie + ";expires=" + date.toGMTString();
  }
  document.cookie = cookie;
}

/**
 * 清除指定cookie键的值
 * @param key 指定要清除的cookie键
**/
function delCookie(key) {
  var date = new Date();
  date.setTime(date.getTime() - 1000);
  document.cookie = key + "='';expires=" + date.toGMTString();
}