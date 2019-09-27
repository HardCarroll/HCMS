<?php
// $data[] = array('volume' => 67, 'edition' => 2);
// $data[] = array('volume' => 86, 'edition' => 1);
// $data[] = array('volume' => 85, 'edition' => 6);
// $data[] = array('volume' => 98, 'edition' => 2);
// $data[] = array('volume' => 86, 'edition' => 6);
// $data[] = array('volume' => 67, 'edition' => 7);

// echo "<br>before sort:<br>";
// print_r($data);

// foreach ($data as $key => $row) {
//   $volume[$key]  = $row['volume'];
//   $edition[$key] = $row['edition'];
// }

// // 将数据根据 volume 降序排列，根据 edition 升序排列
// // 把 $data 作为最后一个参数，以通用键排序
// array_multisort($volume, SORT_DESC, $edition, SORT_ASC, $data);

// echo "<br>after sort:<br>";
// print_r($data);

$data[] = array('name' => 'include', 'type' => 'folder');
$data[] = array('name' => 'media', 'type' => 'folder');
$data[] = array('name' => 'index.php', 'type' => 'file');
$data[] = array('name' => 'plugin', 'type' => 'folder');
$data[] = array('name' => 'install', 'type' => 'folder');
$data[] = array('name' => 'admin', 'type' => 'folder');
$data[] = array('name' => 'temp.php', 'type' => 'file');

foreach ($data as $key => $row) {
  $volume[$key]  = $row['name'];
  $edition[$key] = $row['type'];
}

// 将数据根据 volume 降序排列，根据 edition 升序排列
// 把 $data 作为最后一个参数，以通用键排序
array_multisort($edition, SORT_DESC, $volume, SORT_ASC, $data);

echo "<br>after sort:<br>";
print_r($data);