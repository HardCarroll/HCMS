<?php
header("Content-type:text/html; charset:utf-8;");
date_default_timezone_set("Asia/Shanghai");

/**
 * 数据库管理类
 * 
 */
class DBManager {
  // 主机名
  public $hostname;
  // 数据库用户名
  public $username;
  // 数据库密码
  public $password;
  // 数据库名称
  public $dbname;
  // 数据表名
  public $tabname;
  // 获取分类详细信息的sql字符串
  public $sql_class;
  // 数据库连接字符串
  public $links;
  // 数据库操作的状态信息
  public $state;

  // 构造函数
  function __construct($hostname, $username, $password, $dbname, $tabname) {
    $this->hostname = $hostname;
    $this->username = $username;
    $this->password = $password;
    $this->dbname = $dbname;
    $this->tabname = $tabname;
    $this->sql_class = "SELECT * FROM tab_class WHERE tabname='".$tabname."'";
    $this->link = mysqli_connect($hostname, $username, $password, $dbname);
    $this->state = array("err_no"=>mysqli_connect_errno(), "err_code"=>mysqli_connect_error());
  }

  // 析构函数
  function __destruct() {
    $this->hostname = null;
    $this->username = null;
    $this->password = null;
    $this->dbname = null;
    $this->tabname = null;
    $this->sql_class = null;
    $this->state = null;
    !$this->links or $this->links->close();
  }

  /**
   * 执行SQL语句
   * @param string $sql:要执行SQL语句
   * @return mixed 执行完成后的结果
   */
  public function execute($sql) {
    $result = mysqli_query($this->link, $sql);
    $this->state = array("err_no"=>mysqli_errno($this->link), "err_code"=>mysqli_error($this->link));
    return $result;
  }

  /**
   * 添加数据项
   * @param mixed $data JSON格式的字符串数据
   * @return array 执行完成后的状态信息
   */
  public function addItem($data) {
    $dataArray = json_decode($data, true);
    $sql_h = "INSERT INTO " . $this->tabname . "(";
    $sql_b = ") VALUES(";
    $sql_t = ")";
    foreach($dataArray as $key => $value) {
      $sql_h .= $key;
      // $sql_b .= "'" . $this->formatData($value) . "'";
      
      $sql_b .= "'" . addslashes(is_array($value) ? json_encode($value, 320) : $value) . "'";
      if(end($dataArray) !== $value) {
        $sql_h .= ", ";
        $sql_b .= ", ";
      }
    }
    $sql = $sql_h . $sql_b . $sql_t;
    $this->execute($sql);
    $id = $this->selectItem()[0]["id"];

    // 格式化返回值
    if($this->state["err_no"]) {
      $ret = $this->state;
    }
    else {
      $ret = array("err_no" => $this->state["err_no"], "err_code" => $id);
    }
    return $ret;
  }

  /**
   * 删除数据项
   * @param int $id 删除项对应的id
   */
  public function deleteItem($id) {
    $sql = "DELETE FROM " . $this->tabname . " WHERE id=" . $id;
    $this->execute($sql);
    return $this->state;
  }

  /**
   * 更新数据项
   * @param int $id 更新项对应的id
   * @param string $data 更新项数据的JSON格式字符串
   * @return string $result 执行结果的JSON格式字符串
   */
  public function updateItem($id, $data) {
    // UPDATE table SET key1=value1, key2=value2, ..., keyN=valueN
    $sql_h = "UPDATE $this->tabname SET ";
    $sql_b = "";
    $sql_t = " WHERE id=$id";
    if(!$data) {
      return array("err_no" => -1, "err_code" => "修改的内容不能为空");
    }
    $dataArray = json_decode($data, true);
    foreach($dataArray as $key => $value) {
      $sql_b .= ($key . "='" . addslashes(is_array($value) ? json_encode($value, 320) : $value) . "'");
      if(end($dataArray) !== $value) {
        $sql_b .= ",";
      }
    }
    $sql = $sql_h . $sql_b . $sql_t;
    $this->execute($sql);

    // 格式化返回值
    if($this->state["err_no"]) {
      $ret = $this->state;
    }
    else {
      $ret = array("err_no" => $this->state["err_no"], "err_code" => $id);
    }
    return $ret;
  }
  
  /**
   * 查询数据项，并以数组形式返回记录集
   * @param string $rule  指定查询条件
   * @return array $result  查询结果
   */
  public function selectItem($rule = null) {
    $sql = "SELECT * FROM " . $this->tabname;
    if($rule) {
      $sql .= (" WHERE " . $rule);
    }
    $sql .= " ORDER BY id ASC";

    $result = $this->execute($sql);
    if($result) {
      if ($result->num_rows) {
        // 查询结果行数不为0，，将值格式化到数组中返回
        $ret = array();
        while ($tmp = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          array_unshift($ret, $tmp);
        }
      }
      else {
        // 查询结果行数为0，即没有查询到数据
        $ret = array("err_no" => 0, "err_code" => "记录集为0");
      }
    }
    else {
      // 查询语句有误
      $ret = $this->state;
    }
    return $ret;
  }

  /**
   * 获取记录集总数
   * @param string|null $rule 查询条件
   * @return int 记录集数量
   */
  public function getRecordCounts($rule = null) {
    $counts = 0;
    $result = $this->selectItem($rule);
    if(!isset($result["err_no"])) {
      $counts = count($result);
    }
    return $counts;
  }

  /**
   * 获取对应分类的详细信息，并以数组形式返回记录集
   * @return array $result  查询结果
   */
  public function getClassData() {
    $result = $this->execute($this->sql_class);
    if($result) {
      if ($result->num_rows) {
        // 查询结果行数不为0，，将值格式化到数组中返回
        $ret = array();
        while ($tmp = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          array_unshift($ret, $tmp);
        }
      }
      else {
        // 查询结果行数为0，即没有查询到数据
        $ret = array("err_no" => 0, "err_code" => "记录集为0");
      }
    }
    else {
      // 查询语句有误
      $ret = array("err_no" => 0, "err_code" => "请检查语法错误");
    }
    return $ret;
  }

  /**
   * 生成JSON文件
   */
  public function logJsonFile($id) {
    $clsArray = $this->getClassData()[0];
    $path = ROOT_PATH.$clsArray["jsonPath"];
    $ext = ".json";
    if(is_dir($path) or @mkdir($path, 0777, true)) {
      $result = file_put_contents($path.$id.$ext, json_encode($this->selectItem("id=$id")[0], 320));
    }
    return $result;
  }

  /**
   * 删除JSON文件
   */
  public function removeJsonFile($id) {
    $clsArray = $this->getClassData()[0];
    $path = ROOT_PATH.$clsArray["jsonPath"];
    $ext = ".json";
    @unlink($path.$id.$ext);
  }

  /**
   * 读取JSON文件内容
   */
  public function loadJsonFile($id) {
    $clsArray = $this->getClassData()[0];
    $path = ROOT_PATH.$clsArray["jsonPath"];
    $ext = ".json";
    return file_get_contents($path.$id.$ext);
  }

  /**
   * 生成HTML文件
   */
  public function logHtmlFile($id) {
    $clsArray = $this->getClassData()[0];
    $ext = ".html";
    $htmlPath = $clsArray["htmlPath"].$id.$ext;
    // 获取网站信息数据
    $siteinfo = json_decode(file_get_contents(ROOT_PATH.PATH_JSON."/siteinfo.json"), true);
    $url = "http://".$siteinfo["domain"].$clsArray["tempPath"];
    $str = curl_request($url, json_encode($this->selectItem("id=$id")[0], 320));
    file_put_contents(ROOT_PATH.$htmlPath, $str);
    $result = $this->updateItem($id, '{"b_posted": "T", "st_path": "'.$htmlPath.'"}');
    return $result;
  }

  /**
   * 删除HTML文件
   */
  public function removeHtmlFile($id) {
    $clsArray = $this->getClassData()[0];
    $path = ROOT_PATH.$clsArray["htmlPath"];
    @unlink($path.$id.".html");
  }
}