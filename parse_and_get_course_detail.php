<?php

require("class.filetotext.php");

$file = fopen("test_lp.csv", 'w');
$file_count = 0;

$result = array();

if ($handle = opendir('doc to convert plain')) {

  while (false !== ($entry = readdir($handle))) {

    if ($entry != "." && $entry != ".." && $entry != '.DS_Store') {

      $docObj = new Filetotext('doc to convert plain/'.$entry);
      $return = $docObj->convertToText();

      $text = explode("\n\r", $return);

      $found = 0;
      $row = '';
      $x = 0;
      $row_content = '';
      $course_name = '';
      $code = '';
      $teks_number = '';
      $unit_number = '';
      $unit_name = '';
      $section_number = '';
      $main_content = '';
      $course_req = $pre_req = '';
      $credit = '';
      $corequisite = $recomm_precorequisite = $recomm_corequisite = '';
      for($i=0; $i<count($text); $i++) {
        $write = false;
        $str = trim($text[$i]);

        $match = preg_match('/TSDS PEIMS Code:/',$str);
        if(empty($match)) {
          $match = preg_match('/PEIMS Code:/',$str);
        }
        if($match) {
          $explode = explode(':', $str);
          if($explode[1]) {
            $split = explode(" ", trim($explode[1]));
            $code = str_replace('Course Credit','',$split[0]);
          }
          else {
            $split = explode(" ", trim($text[$i + 1]));
            $code = str_replace('Course Credit','',$split[0]);
          }
          $course_name = $text[$i-1];
        }

        $match = preg_match('/Credit:/',$str);
        if(empty($match)) {
          $match = preg_match('/Credits:/',$str);
        }
        if($match) {
          $explode = explode(':', $str);
          $credit = $explode[1];
        }

        $match = preg_match('/Grade Placement:/',$str);
        if($match) {
          $explode = explode(':', $str);
          $split = str_replace(' ', '-', trim($explode[1]));
          $course_req = str_replace('Grade Placement', '', $split);
        }

        $match = preg_match('/Prerequisite:/',$str);
        if(empty($match)) {
          $match = preg_match('/Prerequisites:/',$str);
        }
        if($match && empty($pre_req)) {
          $explode = explode(':', $str);
          $pre_req = str_replace('Prerequisites','',$explode[1]);
          $pre_req = str_replace('Prerequisite','',$pre_req);
        }

        $match = preg_match('/Corequisite:/',$str);
        if(empty($match)) {
          $match = preg_match('/Corequisites:/',$str);
        }
        if($match && empty($corequisite)) {
          $explode = explode(':', $str);
          $corequisite = str_replace('Corequisite','',$explode[1]);
          $corequisite = str_replace('Corequisites','',$corequisite);

        }

        $match = preg_match('/Recommended Prerequisites:/',$str);
        if(empty($match)) {
          $match = preg_match('/Recommended Prerequisite:/',$str);
        }
        if($match) {
          $explode = explode(':', $str);
          $recomm_precorequisite = str_replace('Course Description','',$explode[1]);

        }

        $match = preg_match('/Recommended Corequisites:/',$str);
        if(empty($match)) {
          $match = preg_match('/Recommended Corequisite:/',$str);
        }
        if($match) {
          $explode = explode(':', $str);
          $recomm_corequisite = str_replace('Course Description','',$explode[1]);

        }

        $next_str = trim($text[$i+1]);
        if(empty($next_str) && !empty($str)) {
          $result[$course_name][$x++]['content'] = [$course_name, $code,
            $course_req, $credit, $pre_req, $recomm_precorequisite, $corequisite, $recomm_corequisite
          ];
          $course_name = $code = $course_req = $pre_req = '';
          $corequisite = $recomm_precorequisite = $recomm_corequisite = '';
          $credit = '';
        }

      }
    }
  }

  closedir($handle);
}


$csv_label = array();
fputcsv($file, ['Course name','TSDS PEIMS Code','Course Requirements', 'Credit', 'Prerequisites','Recommended Prerequisites','Corequisites', 'Recommended Corequisites']);
foreach($result as $key => $val) {
  foreach($val as $v) {
      fputcsv($file, $v['content']);
  }
}
fclose($file);