$(function() {
  // 上一步点击事件
  $(".btn-prev").off("click").on("click", function() {
    $(".step-list").find(".active").install({token: "prev"}).removeClass("active").prev().addClass("active").removeClass("done");
    // $(this).install({token: "prev"});
  });

  // 下一步点击事件
  $(".btn-next").off("click").on("click", function() {
    // console.log($(".step-list").find(".active").index());
    // console.log($(".step-list-item").length);

    $(".step-list").find(".active").install({token: "next"}).removeClass("active").addClass("done").next().addClass("active");
    // $(this).install({token: "next"});
  });

  // 完成点击事件
  $(".btn-done").off("click").on("click", function() {
    $(this).install({token: "done"});
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

      console.log("install() " + this.index());

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

      return _that;
    }
  });

  var defaults = {step: 1, prev: 0, next: 2};

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
    console.log(options);
  }

  function next(options) {
    console.log(options);
  }

  function done(options) {
    console.log(options);
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
