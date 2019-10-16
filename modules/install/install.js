(function($) {
  $.fn.extend({
    install: function(options) {
      // 1, 检查参数合法性
      if (!isValid(options)) {
        return $(this);
      }
      // 2, 重构参数
      var opts = $.extend({}, defaults, options);
      var _that = this;

      // 3, 处理函数
      // do something here
      console.log("install("+JSON.stringify(opts)+")");

      // 4, return让插件得以链式调用
      return opts;
    }
  });

  // 默认参数
  var defaults = {step: 1};

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

  function next(options) {
    var res;
    var fmd = new FormData();
    fmd.append("token", "next");
    fmd.append("step", 1);

    $.ajax({
      url: "./handle.php",
      type: "POST",
      data: fmd,
      contentType: false,
      dataType: "json",
      processData: false,
      async: false, //是否为异步模式
      success: function (result) {
        res = result;
      },
      error: function (error) {
        console.log(error);
      }
    });
    
    return res;
  }
})(jQuery)


// $(function() {
//   var step = 1;

//   $(".btn-prev").off("click").on("click", function() {
//     var fmd = new FormData();
//     fmd.append("token", "prev");
//     fmd.append("step", step);

//     install(fmd);

//     $(".step-item").eq(step-1).removeClass("done");
//   });

//   $(".btn-next").off("click").on("click", function() {
    
//     var fmd = new FormData();
//     fmd.append("token", "next");
//     fmd.append("step", step);
//     console.log(step);

//     var data = {dbAccount: $("#inDBAccount").val(), dbPassword: $("#inDBPassword").val(), dbHost: $("#inDBHost").val(), dbName: $("#inDBName").val(), dbPrefix: $("#inDBPrefix").val()};
//     fmd.append("data", JSON.stringify(data));

//     install(fmd);

//     $(".step-item").eq(step).addClass("done");
//   });

//   $(".btn-done").off("click").on("click", function() {
//     var fmd = new FormData();
//     fmd.append("token", "done");

//     install(fmd);
//   });

//   function install(fmd) {
//     $.ajax({
//       url: "./handle.php",
//       type: "POST",
//       data: fmd,
//       contentType: false,
//       dataType: "json",
//       processData: false,
//       success: function(result) {
//         console.log(result);

//         step = result.step;

//         if(step > 1) {
//           // step (2,4]
          
//           $(".btn-prev").removeClass("hidden");
//           $(".btn-next").removeClass("hidden");
//           $(".btn-done").addClass("hidden");

//           if(step === result.nSteps) {
//             $(".btn-next").addClass("hidden");
//             $(".btn-done").removeClass("hidden");
//           }
//         }
//         else {
//           // step 1
//           $(".btn-prev").addClass("hidden");
//           $(".btn-next").removeClass("hidden");
//         }

//         $(".step-content").empty().html(result.content);

//         if(result.location) {
//           self.location = result.location;
//         }
//       },
//       error: function(error) {
//         console.log(error);
//       }
//     });
//   }
// });