$(function() {
  var step = 1;

  $(".btn-prev").off("click").on("click", function() {
    $.ajax({
      url: "./handle.php",
      type: "POST",
      data: "token=prev&step="+step,
      // contentType: false,
      dataType: "json",
      processData: false,
      success: function(result) {
        step = result.step;
        if(step <= 1) {
          $(".btn-prev").addClass("hidden");
        }

        $(".step-item").eq(step).removeClass("done");
        $(".step-content").empty().html(result.content);

        console.log(result);
      },
      error: function(error) {
        console.log(error);
      }
    });
  });

  $(".btn-next").off("click").on("click", function() {
    var data = {dbAccount: $("#inDBAccount").val(), dbPassword: $("#inDBPassword").val()};
    var fmd = new FormData();
    fmd.append("token", "next");
    fmd.append("step", step);
    fmd.append("data", JSON.stringify(data));
    install(fmd);
  });

  $(".btn-done").off("click").on("click", function() {
    console.log($(this).attr("class"));
  });

  function install(fmd) {
    $.ajax({
      url: "./handle.php",
      type: "POST",
      data: fmd,
      contentType: false,
      dataType: "json",
      processData: false,
      success: function(result) {
        console.log(result);

        step = result.step;
        if(step > 1) {
          $(".btn-prev").removeClass("hidden");
        }
        else {
          $(".btn-prev").addClass("hidden");
        }

        $(".step-item").eq(step-1).addClass("done");

        $(".step-content").empty().html(result.content);
      },
      error: function(error) {
        console.log(error);
      }
    });
  }
});