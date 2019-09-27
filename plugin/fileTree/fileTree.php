<?php
if(isset($_POST["path"]) && !empty($_POST["path"])) {
  echo proc_fileTree($_SERVER["DOCUMENT_ROOT"] . $_POST["path"]);
}
else {
  echo '{"err_no": -1, "err_code": "file is not found!"}';
}

function proc_fileTree($filePath) {
  $retArray = array("err_no" => "", "err_code" => "");
  
  if(file_exists(iconv('UTF-8', 'GB2312', $filePath))) {
    // 给定路径的文件或目录存在    
    $retArray["err_no"] = 0;
    $retArray["err_code"] = fileTree($filePath);
  }
  else {
    // 给定路径的文件或目录不存在
    $retArray["err_no"] = -1;
    $retArray["err_code"] = "请检查" . (formatPath($filePath)) . "是否存在！";
  }

  return json_encode($retArray, 320);
}

function fileTree($filePath) {
  // 1, 格式化返回数组
  $path = formatPath($filePath);
  $resultArray = array("name" => basename($path), "path" => $path, "type" => "file", "sub_file" => "");
  if("/" === $resultArray["path"]) {
    $resultArray["name"] = $_SERVER["HTTP_HOST"];
  }

  // 2, 当路径是文件夹则递归调用
  if (is_dir($filePath)) {
    $resultArray["type"] = "folder";
    $scanArray = scandir($filePath);
    foreach ($scanArray as $file) {
      if ("." !== $file && ".." !== $file) {
        $subArray[] = fileTree($filePath . "/" . $file);

        // 对数组进行排序
        foreach($subArray as $key => $val) {
          $name[$key] = $val["name"];
          $type[$key] = $val["type"];
        }
        array_multisort($type, SORT_DESC, $name, SORT_ASC, $subArray);
      }
    }
    $resultArray["sub_file"] = $subArray;
  }

  // 3, 返回结果
  return $resultArray;
}

function formatPath($path) {
  $path = str_replace($_SERVER["DOCUMENT_ROOT"], "/", $path);
  $path = str_replace("///", "/", $path);
  $path = str_replace("//", "/", $path);
  return $path;
}
