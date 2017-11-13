<?php

require("class.filetotext.php");

$file = fopen("test_lp.csv", 'w');
$file_count = 0;

$result = array();

$compare = [];
$check_code = [];
$entry_array = [];
$teks_number = [];
$read_csv = fopen("TEKS_txcte.csv", 'r');
while (!feof($read_csv)) {
  $record1 = fgetcsv($read_csv);
  $node_id = $record1[0];
  $code = $record1[2];
  $resource_id = $record1[1];
  array_push($compare, array('node' => $node_id,'resource_id' => $resource_id, 'teks' => $code));
}

if ($handle = opendir('txcte/test')) {

  while (false !== ($entry = readdir($handle))) {

    if ($entry != "." && $entry != ".." && $entry != '.DS_Store') {

      $docObj = new Filetotext('txcte/test/'.$entry);
      $return = $docObj->convertToText();

      $text = explode("\n\r", $return);

      $found = 0;
      $row = '';
      $x = 0;
      $row_content = '';
      $course_name = '';
      $code = '';
      $unit_number = '';
      $unit_name = '';
      $section_number = '';
      $main_content = '';
      $file_id = '';
      $file_id = explode('____', $entry);
      for($i=0; $i<count($text); $i++) {
        $write = false;
        $str = $text[$i];

        $status = 0;
        $continue = 0;
        if($file_id[0] == 6689) {
          $t = ";;;";
        }

        preg_match_all('#\d{3}+(?:\.[0-9]{1,3})?#', $str, $matches);
        if($matches[0]) {
          $code = implode('.',$matches[0]);
          $status = 1;
        }
        $sub_section = [];
        $section = '';
        $section_number = [];

        if($status == 1) {
          for($j=($i+1); $j<35; $j++) {
            if(!isset($text[$j])) {
              continue;
            }
            $sub_string = $text[$j];
            preg_match('/\([A-Z]\)/',$sub_string, $match_char);
            preg_match('/^\([0-9]*\)/',$sub_string, $match_number);
            if(!empty($match_char)) {
              preg_match('#\((.*?)\)#', $match_char[0], $m_string);
              $sub_section[$section][] = $m_string[1];
            }
            else if(!empty($match_number)) {
              preg_match('#\((.*?)\)#', $match_number[0], $m_string);
              $section_number[] = $m_string[1];
              $section = $m_string[1];
            }
          }
          foreach($section_number as $k => $v) {
            if(isset($sub_section[$v])) {
              foreach ($sub_section[$v] as $x => $y) {
                $teks = $code . '.c.' . $v . '.' . $y;
                array_push($teks_number, ['node_id'=>$file_id[0], 'code' => $teks]);
              }
            }
            else {
              $teks = $code . '.c.' . $v;
              array_push($teks_number, ['node_id'=>$file_id[0], 'code' => $teks]);
            }
          }
          $status = 0;
          $continue = 1;
        //  $j = count($text);
        }

        if($continue == 1) {
          $i = count($text);
        }
      }
    }
  }

  closedir($handle);
}

$csv_label = array();

$node_list = [];
fputcsv($file, ['Node ID','Resource ID','TEKS in TCRC','TEKS in LP','LP Resource id']);
foreach($compare as $key => $val) {
  $tek = $val['teks'];
  $resource_id = $val['resource_id'];
  $node = $val['node'];

  $array = [];
  $array[] = $val['node'];
  $array[] = $val['resource_id'];
  $assign_array = $tmp_array = $array;
  $array[] = $val['teks'];
  $node_list[$val['resource_id']] = $val['node'];
  foreach($teks_number as $k => $v) {
    if($v['node_id'] == $val['resource_id'] && $v['code'] == $tek) {
      $array[] = $tek;
      $array[] = $v['node_id'];
      unset($teks_number[$k]);

    }
  }
  fputcsv($file, $array);

}

foreach($teks_number as $k => $v) {
  $array = [];
  $array[] = $node_list[$v['node_id']];
  $array[] = $v['node_id'];
  $array[] = '';
  $array[] = $v['code'];
  $array[] = $v['node_id'];
  fputcsv($file, $array);

}

fclose($file);