<?php
$val = '{"err_no": 0, "err_code": "hello world", "token": "'.$_POST["token"].'"}';
$val = str_replace("../", "", $val);
$val = str_replace("./", "", $val);
echo $val;
// echo json_encode($val, 320);