<?php
$rootPath = $_SERVER["DOCUMENT_ROOT"];

// banner data
$bn_json = '{
  "pic": [{"url": "/media/image/bn1.jpg", "attr_alt": "", "attr_title": ""}, {"url": "/media/image/bn2.jpg", "attr_alt": "", "attr_title": ""}, {"url": "/media/image/bn3.jpg", "attr_alt": "", "attr_title": ""}, {"url": "/media/image/bn4.jpg", "attr_alt": "", "attr_title": ""}, {"url": "/media/image/bn5.jpg", "attr_alt": "", "attr_title": ""}]
}';
$bn_data = json_decode($bn_json, TRUE);
$bn_pic = $bn_data["pic"];

// works data
$wk_col = 3;
$wk_data = file_get_contents($rootPath . "/testdata/works.json");
$wk_array = json_decode($wk_data, TRUE);

// trends data
$ts_json = file_get_contents($rootPath."/testdata/trends.json");
$ts_array = json_decode($ts_json, TRUE);

// news data
$ns_json = file_get_contents($rootPath."/testdata/news.json");
$ns_array = json_decode($ns_json, TRUE);

// cases data
$cs_json = file_get_contents($rootPath."/testdata/cases.json");
$cs_array = json_decode($cs_json, TRUE);

?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="renderer" content="webkit">
  <link rel="stylesheet" href="/include/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/include/css/shared.min.css">
  <title>炉石空间设计丨专注于酒店、餐饮、KTV等室内空间设计</title>
</head>

<body>
  <div class="layer">
    <!-- navbar area -->
    <div id="hsd-navigation" class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#hsd-navbar" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><b>HEARTHSTONE</b> DESIGN</a>
        </div>
        <div class="collapse navbar-collapse" id="hsd-navbar">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="/">首页</a></li>
            <li class="dropdown">
              <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span>作品案例</span>
                <!-- <span class="caret"> -->
              </a>
              <ul class="dropdown-menu">
                <li><a href="#"><span>品牌设计</span></a></li>
                <li><a href="#"><span>空间设计</span></a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#"><span>其他作品</span></a></li>
              </ul>
            </li>
            <li><a href="/"><span>关于我们</span></a></li>
            <li><a href="/"><span>联系我们</span></a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- banner area -->
    <div id="hsd-carousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <?php
        for ($i = 0; $i < count($bn_pic); $i++) {
          echo '<li data-target="#hsd-carousel" data-slide-to="' . $i . '"></li>';
        }
        ?>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <?php
        for ($i = 0; $i < count($bn_pic); $i++) {
          echo '<div class="item"><img draggable="false" src="' . $bn_pic[$i]["url"] . '" alt="' . $bn_pic[$i]["attr_alt"] . '" title="' . $bn_pic[$i]["attr_title"] . '"></div>';
        }
        ?>
      </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#hsd-carousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#hsd-carousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <!-- company intro area -->
    <div class="intro" id="hsd-intro">
      <div class="txt">
        <p>英文全称：“HEARTHSTONE DESIGN ”</p>
        <p>炉石(HEARTHSTONE)—真金不怕红炉火，石山不怕雨来淋。释义着我们对设计态度的执着与真挚，对专业知识的精湛及理解。</p>
        <p>我们是一家专注于酒店、餐饮、KTV等室内空间的专业设计机构，拥有专业优秀的空间设计、软装设计和施工工程监理的团队，服务客户遍布全国，近年来与国内众多知名商业连锁品牌保持着良好稳定持续的合作关系，在餐饮和娱乐设计领域积累了难得的宝贵经验，本着“风格至上，细节至美”的理念，设计作品得到越来越多的业内人士和客户的高度认可，湖南炉石空间设计为您的商业空间效果展现保驾护航。</p>
      </div>
      <div class="pic">
        <img src="/media/image/hsd-light.jpg" alt="酒店设计、餐饮设计、KTV设计、室内空间设计、品牌全案策划" title="炉石空间设计">
        <p>炉石空间设计</p>
      </div>
    </div>

    <!-- display works area -->
    <div class="works" id="hsd-works">
      <div class="head">SEE OUR WORKS</div>
      <div id="waterfall" class="container-fluid row">
        <?php
        for ($i = 0; $i < $wk_col; $i++) {
          echo '<div class="col-xs-12 col-sm-' . (12 / $wk_col) . ' column">';
          for ($j = 0; $i + $wk_col * $j < count($wk_array); $j++) {
            $wk_item = $wk_array[$i + $wk_col * $j];
            echo '<a href="' . $wk_item["url"] . '" class="item">
            <div class="pic">
              <img src="' . $wk_item["poster"]["url"] . '" alt="' . $wk_item["poster"]["attr_alt"] . '" title="' . $wk_item["poster"]["attr_title"] . '">
            </div>
            <div class="detail">
              <span>' . $wk_item["name"] . '</span>
              <span>' . $wk_item["tags"] . '-' . $wk_item["addr"] . '</span>
            </div>
            <div class="mask">
              <p class="name">' . $wk_item["name"] . '</p>
              <p class="addr">' . $wk_item["addr"] . '</p>
              <p class="tags">' . $wk_item["tags"] . '</p>
            </div>
          </a>';
          }
          echo '</div>';
        }
        ?>
      </div>
      <div class="foot">
        <a href="/works/">VIEW MORE</a>
      </div>
    </div>

    <!-- state area -->
    <div id="hsd-state" class="state">
      <div class="container-fluid row">
        <div class="col-xs-12 col-sm-4 col-sm-offset-4 content">
          <p>合作提示:</p>
          <p>搞关系不是我们擅长的,我们不参与比稿。</p>
          <p style="text-indent: 2em;">这个行业里的牛人大咖，都是靠扎扎实实的专业（崇尚专业至上+口碑传播）。我们没有时间搞关系，我们也没有时间跟客户讨价还价。我们也不参与任何形式的比稿，因为我们要把更多的时间和精力投入到落地方案中，我们更加注重为现有客户负责。在我们眼中,只有朋友,没有客户。</p>
          <p style="text-indent: 2em;">所以当我们说话直率客观的时候,请您不要介意,我们只会就事谈事而不会附和您。对我们来说,客户的潜质很重要，我们很重视对品质要求苛刻和固执的合作伙伴。我们会把您的意见和需求都实现在落地方案中,我们只会用效果说话。</p>
        </div>
      </div>
    </div>

    <!-- trends and news area -->
    <div class="dynamic" id="hsd-dynamic">
      <div class="inner container-fluid row">
        <div class="column trends col-xs-12 col-sm-4">
          <a class="title" href="/trends/">TRENDS 行业趋势</a>
          <?php
          for($i=0; $i<count($ts_array); $i++) {
            $ts_item = $ts_array[$i];
            echo '<a href="'.$ts_item["url"].'" class="text-ellipsis item">'.$ts_item["title"].'</a>';
          }
          ?>
        </div>
        <div class="column news col-xs-12 col-sm-4">
          <a class="title" href="/news/">NEWS 炉石动态</a>
          <?php
          for($i=0; $i<count($ns_array); $i++) {
            $ns_item = $ns_array[$i];
            echo '<a href="'.$ns_item["url"].'" class="text-ellipsis item">'.$ns_item["title"].'</a>';
          }
          ?>
        </div>
        <div class="column cases col-xs-12 col-sm-4">
          <a class="title" href="/cases/">CASES 案例赏析</a>
          <?php
          for($i=0; $i<count($cs_array); $i++) {
            $cs_item = $cs_array[$i];
            echo '<a href="'.$cs_item["url"].'" class="text-ellipsis item">'.$cs_item["title"].'</a>';
          }
          ?>
        </div>
      </div>
    </div>

    <div class="types" id="hsd-types">
      <div class="inner container-fluid row">
        <div class="column space col-xs-12 col-sm-4">
          <a class="title" href="/case/space.php">SPACE DESIGN 空间设计</a>
          <?php
          $tag_space = ["餐厅设计", "酒店设计", "别墅设计", "办公空间设计", "展厅设计", "软装设计"];
          for($i=0; $i<count($tag_space); $i++) {
            echo '<a href="/case/space.php" class="text-ellipsis item">'.$tag_space[$i].'</a>';
          }
          ?>
        </div>
        <div class="column brand col-xs-12 col-sm-4 col-sm-offset-4">
          <a class="title" href="/brand/">BRAND DESIGN 品牌设计</a>
          <?php
          $tag_brand = ["视觉识别策略", "品牌改造设计", "产品包装设计", "形象画册设计", "形象海报设计", "标志设计"];
          for($i=0; $i<count($tag_brand); $i++) {
            echo '<a href="/case/space.php" class="text-ellipsis item">'.$tag_brand[$i].'</a>';
          }
          ?>
        </div>
      </div>
    </div>

    <div class="contact" id="hsd-contact">
      <div class="inner container-fluid row">
        <div class="column col-xs-12 col-sm-6">
          <h2 class="logo">HEARTHSTONE</h2>
          <p class="addr">地址：湖南省长沙市长沙县开元中路星大花园1408室</p>
          <p class="moblie">Mob：15388933393</p>
          <p class="qq">QQ：476000121</p>
          <p class="email">E-mail：476000121@qq.com</p>
          <a href="http://www.hs1design.com" class="website">炉石空间设计（www.hs1design.com）</a>
          <p>Copyright © 2020 HEARTHSTONE DESIGN ALL Rights Reserved.</p>
          <p>本网站中所展示的作品著作权均属于炉石空间设计所有。</p>
          <p>酒店、餐厅、办公空间、民俗、展厅</p>
          <a href="http://www.beian.miit.gov.cn" target="_blank" class="icp"><img src="/media/image/icp.jpg">湘ICP备88888888号-1</a>
          <div class="qrcode-cus"><img src="/media/image/qrcode_cus.jpg" alt=""><span>客服微信号</span></div>
        </div>
      </div>
    </div>

  </div>

</body>
<script src="/include/jquery/jquery.min.js"></script>
<script src="/include/bootstrap/js/bootstrap.min.js"></script>
<script>
  $(function() {
    $("#hsd-carousel .carousel-indicators li").eq(0).addClass("active");
    $("#hsd-carousel .carousel-inner .item").eq(0).addClass("active");
  });
</script>

</html>