<?php


$file1 = fopen("teks_list.csv", 'r');
$file3 = fopen("files_export/teks_list_short.csv", 'w');

$compare_array = [];
$array = [];

$records_to_write = [];
$unique_array = [];
while (!feof($file1)) {
$records = [];
  $record1 = fgetcsv($file1);
  $records[] = $record1[0];
  $records[] = $record1[1];
  $records[] = $record1[2];
  $length = count($record1);
  for($z = 3; $z < $length; $z++) {
    $row_to_write = $records;
    $teks = $record1[$z];
    $pieces = explode(')', $teks);
    $part1 = implode(')', array_slice($pieces, 0, 3));
    $row_to_write[] = $part1 . ')';
    fputcsv($file3, $row_to_write);
  }
}
fclose($file1);


fclose($file3);


