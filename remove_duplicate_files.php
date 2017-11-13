<?php

require("class.filetotext.php");

$file1 = fopen("files_export/resources.csv", 'r');
$file3 = fopen("files_export/concatenate.csv", 'w');

$compare_array = [];
$array = [];
$records = [];
$records_to_write = [];
$unique_array = [];
while (!feof($file1)) {
  $record1 = fgetcsv($file1);
  $node_id = $record1[0];
  $records[$node_id][] = $record1;
  array_push($compare_array, $node_id);
}
$unique_array = array_unique($compare_array);
fclose($file1);

foreach ($unique_array as $val) {
  $node = $val;
  $records_to_write[$node] = $records[$node][0];
  if(array_keys_exist($records, $node) != 1) {
    $files = [];
    foreach($records[$node] as $k => $v) {
      $files[] = $v[12];
    }
    $records_to_write[$node][12] = implode(";", $files);
  }
}

foreach($records_to_write as $key => $val) {
  fputcsv($file3, $val);
}


fclose($file3);


function array_keys_exist( array $array, $keys ) {
  return count($array[$keys]);
}