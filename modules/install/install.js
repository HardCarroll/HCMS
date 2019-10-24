$(function() {
  // 上一步点击事件
  $(".btn-prev").off("click").on("click", function() {
    // $(".step-list").find(".active").removeClass("active").prev().addClass("active").removeClass("done").install({token: "prev"});
    $(this).install({token: "prev"});
  });

  // 下一步点击事件
  $(".btn-next").off("click").on("click", function() {

    // $(".step-list").find(".active").removeClass("active").addClass("done").next().addClass("active").install({token: "next"});
    $(this).install({token: "next"});
  });

  // 完成点击事件
  $(".btn-done").off("click").on("click", function() {
    $(this).install({token: "done"});
  });

  $(".btn-debug").click(function() {
    // var nodes = $(".step-table").find(".step-table-item.active").find(".input-group");
    // for(var i=0; i<nodes.length; i++) {
    //   console.log(nodes[i]);
    // }

    $.ajax({
      url: "./handle.php",
      type: "post",
      data: "token=save",
      dataType: "json",
      processData: false,
      success: function(result) {
        console.log(result);
      },
      error: function(error) {
        console.log("error: " + error);
      }
    });

    $.ajax({
      url: "./handle.php",
      type: "post",
      data: "token=load",
      dataType: "json",
      processData: false,
      success: function(result) {
        console.log(result);
      },
      error: function(error) {
        console.log("error: " + error);
      }
    });
    
  });

});

(function($){
  $.fn.extend({
    install: function(options) {
      // 1, 检查参数合法性
      if (!isValid(options)) {
        return this;
      }
      
      var _that = this;
      var opts = $.extend({}, defaults, options);

      // opts.step = this.index();
      // console.log("install() " + this.index());
      // console.log(opts.step = $(".step-list").find(".active").index());
      // $(".step-table-item").eq(opts.step).addClass("active").siblings().removeClass("active");

      switch(opts.token) {
        case "prev":
          prev(opts);
          break;
        case "next":
          next(opts);
          break;
        case "done":
          done(opts);
          break;
      }

      aysncStatus(opts);

      console.log(opts);

      return _that;
    }
  });

  var defaults = {};

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

  function prev(options) {
    options.index = $(".step-list").find(".active").removeClass("active").prev().addClass("active").removeClass("done").index();
    $(".step-table-item").eq(options.index).addClass("active").siblings().removeClass("active");
    
    options.backward = options.index+1;
  }

  function next(options) {
    options.index = $(".step-list").find(".active").removeClass("active").addClass("done").next().addClass("active").index();
    $(".step-table-item").eq(options.index).addClass("active").siblings().removeClass("active");
    
    options.backward = options.index-1;
    // switch(options.backward) {
    //   case 0:
    //     break;
    //   case 1:
    //     break;
    //   case 2:
    //     break;
    //   case 3:
    //     break;
    // }

    // var fmd = new FormData();
    // fmd.append("token", "next");

    // fmd.append("db_account", $("#inDBAccount").val());
    // fmd.append("db_password", $("#inDBPassword").val());
    // fmd.append("db_host", $("#inDBHost").val());
    // fmd.append("db_name", $("#inDBName").val());

    // saveData(fmd);
    
  }

  function done(options) {
    console.log(options);
  }

  function saveData(data) {
    // 
    $.ajax({
      url: "./handle.php",
      type: "post",
      data: data,
      contentType: false,
      dataType: "json",
      processData: false,
      aysnc: true,
      success: function(result) {
        console.log(result);
      },
      error: function(msg) {
        console.log("error: " + msg);
      }
    });
  }
  
  function aysncStatus(options) {
    if(options.index === 0) {
      $(".btn-prev").addClass("hidden");
    }
    else {
      $(".btn-prev").removeClass("hidden");
    }

    if(options.index === 3) {
      $(".btn-next").addClass("hidden");
      $(".btn-done").removeClass("hidden");
    }
    else {
      $(".btn-done").addClass("hidden");
      $(".btn-next").removeClass("hidden");
    }
  }

})(jQuery)


// (function($) {
//   $.fn.extend({
//     install: function(options) {
//       // 1, 检查参数合法性
//       if (!isValid(options)) {
//         return $(this);
//       }
//       // 2, 重构参数
//       var opts = $.extend({}, defaults, options);
//       var _that = this;

//       // 3, 处理函数
//       // do something here
//       // console.log("install("+JSON.stringify(opts)+")");

//       // $(".step-item").eq(opts.step).addClass("active");

//       var fmd = new FormData();
//       fmd.append("token", opts.token);
//       fmd.append("step", opts.step);

//       return installing(fmd);

//       // 4, return让插件得以链式调用
//       // return _that;
//     },
//     debug: function() {
//       var _that = this;
//       // console.log(global);
//       return _that;
//     }
//   });

//   // 默认参数
//   var defaults = {step: 1, token: "next", next: 2, prev: 0};

//   // var global = $.extend({}, defaults);

//   // 私有方法，不能被外部访问
//   // 检查参数合法性
//   function isValid(options) {
//     if (!options || (options && "object" === typeof(options))) {
//       return true;
//     }
//     else {
//       alert("the parameter is not valid, please check it!");
//       return false;
//     }
//   }

//   function installing(fmd) {
//     var step;

//     $.ajax({
//       url: "./handle.php",
//       type: "POST",
//       data: fmd,
//       contentType: false,
//       dataType: "json",
//       processData: false,
//       async: false,
//       success: function(result) {
//         // console.log(result);

//         step = result.step;

//         btnStatus(result);
        
//         $(".step-content").empty().html(result.content);

//         if(result.location) {
//           self.location = result.location;
//         }
//       },
//       error: function(error) {
//         console.log(error);
//       }
//     });

//     return step;
//   }

//   function btnStatus(result) {
//     if (result.step > 1) {
//       // step (2,4]
//       $(".btn-prev").removeClass("hidden");
//       $(".btn-next").removeClass("hidden");
//       $(".btn-done").addClass("hidden");

//       if (result.step === result.count_steps) {
//         $(".btn-next").addClass("hidden");
//         $(".btn-done").removeClass("hidden");
//       }
//     }
//     else {
//       // step 1
//       $(".btn-prev").addClass("hidden");
//       $(".btn-next").removeClass("hidden");
//     }

//     if(result.token === "prev") {
//       $(".step-item.active").removeClass("active").prev().removeClass("done").addClass("active");
//     }
//     else if(result.token === "next") {
//       $(".step-item.active").addClass("done").removeClass("active").next().addClass("active");
//     }
//   }

// })(jQuery)
