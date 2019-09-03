$(function(){
  // 账号密码输入框(#in_account, #in_password)
  // 输入内容变化处理函数
  $("#in_account, #in_password").on("input", function(){
    if($(this).next().hasClass("hidden")) {
      $(this).next().removeClass("hidden");
    }
    else {
      if(!$(this).val()) {
        $(this).next().addClass("hidden");
      }
    }
  });

  // 获取焦点处理函数
  $("#in_account, #in_password").focus(function(e){
    if($(this).val()) {
      setTimeout(function(){
        $(e.target).next().removeClass("hidden");
      }, 200, e.target);
    }
  });

  // 失去焦点处理函数
  $("#in_account, #in_password").blur(function(e){
    setTimeout(function(){
      $(e.target).next().addClass("hidden");
    }, 200, e.target);
  });

  // 清空按钮(.empty-value)点击处理函数
  $(".empty-value").on("click", function(){
    $(this).addClass("hidden").prev().val("").focus();
  });

  // 登录按钮(.btn-login)点击处理函数
  $(".btn-login").on("click", function(e){
    e.stopPropagation();
    e.preventDefault();
    var $btn = $(this).button('loading');
    var fmd_login = new FormData();
    var data_login = {id: $("#in_account").val(), pwd: $("#in_password").val()};
    fmd_login.append('token', 'login');
    fmd_login.append('data', JSON.stringify(data_login));
    $.ajax({
      url: "/cms/include/php/handle.php",
      type: "POST",
      data: fmd_login,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(result) {
        if (result.href) {
          window.location.href = result.href;
        }
        else {
          $("#out_message").html(result.err_code);
          setTimeout(function() {$("#out_message").html("");}, 1200);
        }
        $btn.button('reset');
      },
      error: function(msg) {
        console.log("fail: " + msg);
      }

    });
  });
});