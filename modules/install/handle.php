<?php
session_start();

$token = $_POST["token"];
$step = $_POST["step"];

if(!isset($_SESSION["step"]) || empty($_SESSION["step"]) || $_SESSION["step"] !== intval($step)) {
  $_SESSION["step"] = 1;
}
if(!isset($_SESSION["count_steps"]) || empty($_SESSION["count_steps"])) {
  $_SESSION["count_steps"] = 5;
}

if(isset($token) && !empty($token)) {
  if("prev" === $token && $step > 1) {
    $_SESSION["step"] = $step -= 1;
  }
  else if("next" === $token && $step < $_SESSION["count_steps"]-1) {
    $_SESSION["step"] = $step += 1;
  }

}

$ret["step"] = $_SESSION["step"];
$ret["data"] = json_decode($_POST["data"], true);
$ret["content"] = file_get_contents("./step".$ret["step"]);

echo json_encode($ret, 320);