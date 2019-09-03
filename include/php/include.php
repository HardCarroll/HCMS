<?php
session_start();
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]);
require_once(ROOT_PATH."/cms/include/php/path_def.php");
require_once(ROOT_PATH."/cms/include/php/class_def.php");
$userManage = new DBManager("localhost", "hsd_admin", "hs1design.com", "hs1design", "tab_admin");
$caseManage = new DBManager("localhost", "hsd_admin", "hs1design.com", "hs1design", "tab_case");
$articleManage = new DBManager("localhost", "hsd_admin", "hs1design.com", "hs1design", "tab_article");
$classManage = new DBManager("localhost", "hsd_admin", "hs1design.com", "hs1design", "tab_class");
?>