<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Color Board</title>
  <link rel="stylesheet" href="/include/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./colorboard.css">
</head>
<body>
  <div class="board">
    <!-- <div class="container-fluid row"> -->
      <?php
      $color_json = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/color board/colorboard.json");
      $color_array = json_decode($color_json, TRUE);
      for($col=0; $col<5; $col++) {
        echo '<div class="column">';
        for($i=0; $col+$i*5<count($color_array); $i++) {
          $item = $color_array[$col+$i*5];
          echo '<div class="item" data-color="'.$item["value"].'"><span class="name">'.$item["name"].'</span><span class="value">'.$item["value"].'</span></div>';
        }
        echo '</div>';
      }
      ?>
    <!-- </div> -->
  </div>
  <script src="/include/jquery/jquery.min.js"></script>
  <script>
    $(function() {
      $(".board .item").each(function() {
        $(this).css({"background-color": $(this).attr("data-color")});
      });
    });
  </script>
</body>
</html>