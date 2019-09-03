$(function() {
  // 网站信息标签页输入框输入内容
  $(".site-wrap input, .site-wrap textarea").on("input", function() {
    $(".btn-save").removeClass("disabled");
  });
  // 保存按钮点击事件处理函数
  $(".btn-save").off("click").on("click", function() {
    save_siteInfo();
  });

  refresh_siteTab();
});


/**
 * ajax更新网站信息
 */
function refresh_siteTab() {
  var fmd = new FormData();
  fmd.append("token", "getSiteInfo");
  $.ajax({
    url: "/cms/include/php/handle.php",
    type: "POST",
    data: fmd,
    processData: false,
    contentType: false,   //数据为formData时必须定义此项
    dataType: "json",     //返回json格式数据
    context: $(".site-wrap"),
    success: function(result) {
      if(result) {
        $(this).find("[id='domain']").val(result.domain);
        $(this).find("[id='title']").val(result.title);
        $(this).find("[id='keywords']").val(result.keywords);
        $(this).find("[id='description']").val(result.description);
        setCookie("siteInfo", JSON.stringify(result));
        // setCookie("siteInfo", result);
      }
    },
    error: function(err) {
      console.log("fail: "+err);
    }
  }); // ajax_func
}

/**
 * ajax设置网站基本信息，并反馈状态信息
 */
function save_siteInfo() {
  var fmd = new FormData();
  var siteInfo = '{"domain":"'+$("#domain").val()+'", "title": "'+$("#title").val()+'", "keywords": "'+$("#keywords").val()+'", "description": "'+$("#description").val()+'"}';
  fmd.append("token", "setSiteInfo");
  fmd.append("siteInfo", siteInfo);
  $.ajax({
    url: "/cms/include/php/handle.php",
    type: "POST",
    data: fmd,
    processData: false,
    contentType: false,   //数据为formData时必须定义此项
    dataType: "json",     //返回json格式数据
    context: $("#siteTab"),
    success: function(result) {
      $(this).find(".text-state").addClass("text-success").html(result.err_code);
      $(this).find(".btn-save").addClass("disabled");
      setTimeout(function() {
        $(".text-state").html("&nbsp;");
      }, 2000);
    },
    error: function(err) {
      console.log("fail: "+err);
    }
  }); // ajax_func
}