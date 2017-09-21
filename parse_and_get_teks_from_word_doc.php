<?php

require("class.filetotext.php");

$file = fopen("test.csv", 'w');
$file_count = 0;

$result = array();
if ($handle = opendir('doc to convert')) {

  while (false !== ($entry = readdir($handle))) {

    if ($entry != "." && $entry != ".." && $entry != '.DS_Store') {

      $docObj = new Filetotext('doc to convert/'.$entry);
      $return = $docObj->convertToText();

      $text = explode("\n\r", $return);

      $found = 0;
      $row = '';
      $x = 0;
      $row_content = '';
      $course = '';
      $section = '';
      $sub_section = '';
      $section_number = '';
      $main_content = '';
      for($i=0; $i<count($text); $i++) {
        $str = $text[$i];
        $match = preg_match('/Adopted 2015/',$str);
        if($match) {
          $course = $str;
          $section_array = explode(".", $str);
          $section = $section_array[0].".".$section_array[1];
          $found = 0;
        }
        $match = preg_match('/\(c\)/',$str);
        if($match) {
          $sub_section = '(c)';
          $found = 1;
          continue;
        }

        $match = [];
        preg_match('/\([0-9]\)[\t]/',$str, $match);
        if(isset($match[0]) && $match[0] && $found == 1) {
          $section_number = $match[0];
          $main_content = str_replace($section_number, '', $str);
          $section_number = str_replace("\t", '', $section_number);
          continue;
        }

        $match = [];
        preg_match('/\([A-Z]\)\t/',$str, $match);
        if(isset($match[0]) && $match[0] && $found == 1) {
          $item_number = $match[0];
          $row_content = str_replace($item_number, '', $str);
          $result[$course][$x++]['content'] = $section . '. '. $sub_section . $section_number . $item_number . $main_content . $row_content;
        }
      }
    }
  }

  closedir($handle);
}


$csv_label = array();
foreach($result as $key => $val) {
  foreach($val as $v) {
    $content = str_replace("\t",' ', $v['content']);
    fputcsv($file, array($key, $content));
  }
}
fclose($file);