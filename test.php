<?php
$f = $_FILES["files"];
foreach($f["tmp_name"] as $key=>$val) {
  move_uploaded_file($val, $_SERVER["DOCUMENT_ROOT"]."/upload/".$f["name"][$key]);
}
// echo json_encode($res, 320);