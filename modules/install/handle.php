<?php
// session_start();

// $token = $_POST["token"];
// $step = $_POST["step"];

// if(!isset($_SESSION["step"]) || empty($_SESSION["step"]) || $_SESSION["step"] !== intval($step)) {
//   $_SESSION["step"] = 1;
// }
// if(!isset($_SESSION["count_steps"]) || empty($_SESSION["count_steps"])) {
//   $_SESSION["count_steps"] = 4;
// }

// switch($step) {
//   case 1:
//     $ret["data"] = "saveStep(1)";
//   break;
//   case 2:
//     $ret["data"] = "saveStep(2)";
//   break;
//   case 3:
//     $ret["data"] = "saveStep(3)";
//   break;
//   case 4:
//     $ret["data"] = "saveStep(4)";
//   break;
//   default:
//   break;
// }

// if(isset($token) && !empty($token)) {
//   switch($token) {
//     case "prev":
//       if($step > 1) {
//         $_SESSION["step"] = $step -= 1;
//       }
//     break;
//     case "next":
//       if($step < $_SESSION["count_steps"]) {
//         $_SESSION["step"] = $step += 1;
//       }
//     break;
//     case "done":
//       $_SESSION["bInstalled"] = true;
//       touch($_SERVER["DOCUMENT_ROOT"]."/modules/install/.installed.lock");
//       $ret["location"] = "/";
//     break;
//   }
// }

// $ret["token"] = $_POST["token"];
// $ret["step"] = $_SESSION["step"];
// $ret["count_steps"] = $_SESSION["count_steps"];
// $ret["content"] = file_get_contents("./step".$ret["step"]);

// echo json_encode($ret, 320);
