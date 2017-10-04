<?php

require("class.filetotext.php");

$file = fopen("test_lp.csv", 'w');
$file_count = 0;

$result = array();

$compare = [];
$check_code = [];
$read_csv = fopen("course_list.csv", 'r');
while (!feof($read_csv)) {
  $record1 = fgetcsv($read_csv);
  $course_name = $record1[0];
  $code = $record1[1];
  $course_req = $record1[2];
  $credit = $record1[3];
  $pre_req = $record1[4];
  $recomm_pre_req = $record1[5];
  $core_req = $record1[6];
  $recomm_core_req = $record1[7];
  if(!isset($compare[$code])) {
    $compare[$code] = [];
  }
  array_push($compare[$code], array('course_name' => $course_name, 'code' => $code, 'course_requirement' => $course_req,
    'credit' => $credit, 'prerequisite' => $pre_req, 'recommended_prerequisites' => $recomm_pre_req, 'corerequisites' => $core_req,
    'recommended_corerequisites' => $recomm_core_req));
  $check_code[] = $code;
}

  $check_code = array_unique($check_code);

if ($handle = opendir('doc to convert/Regular Scope and Sequence Files')) {

  while (false !== ($entry = readdir($handle))) {

    if ($entry != "." && $entry != ".." && $entry != '.DS_Store') {

      $docObj = new Filetotext('doc to convert/Regular Scope and Sequence Files/'.$entry);
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
        $str = $text[$i];
        $match = preg_match('/Course Name:/',$str);
        if($match) {
          $explode = explode(':', $str);
          $course_name = trim($explode[1]);
        }
        $match = preg_match('/TSDS PEIMS Code:/',$str);
        if(empty($match)) {
          $match = preg_match('/PEIMS Code:/',$str);
        }
        if($match) {
          $explode = explode(':', $str);
          $code = trim(str_replace('Course Credit','',$explode[1]));
        }

        $match = preg_match('/Course Requirements:/',$str);
        if($match) {
          $explode = explode(':', $str);
          $explode = explode('Recommended Prerequisites', $explode[1]);
          $course_req = str_replace('Course Requirements','',$explode[0]);
          if(isset($explode[2])) {
            $course_req = $course_req . ' ' . $explode[2];
          }
        }

        $match = preg_match('/Course Credit:/',$str);
        $split_str = 'Course Credit:';
        if(empty($match)) {
          $match = preg_match('/Course Credits:/',$str);
          $split_str = 'Course Credits:';
        }
        if($match) {
          $explode = explode($split_str, $str);
          $credit = str_replace('Course Requirements','',$explode[1]);
        }



        $match = preg_match('/Recommended Prerequisites:/',$str);
        $split_str = 'Recommended Prerequisites:';
        if(empty($match)) {
          $match = preg_match('/Recommended Prerequisite:/',$str);
          $split_str = 'Recommended Prerequisite:';
        }
        if(empty($match)) {
          $match = preg_match('/Recommended prerequisites:/',$str);
          $split_str = 'Recommended prerequisites:';
        }
        if(empty($match)) {
          $match = preg_match('/Recommended prerequisite:/',$str);
          $split_str = 'Recommended prerequisite:';
        }
        if($match) {
          $explode = explode($split_str, $str);
          $split = explode('Course Description', $explode[1]);
          $recomm_precorequisite = str_replace('Course Description','',$split[0]);
        }

        $match = preg_match('/Recommended Corequisites:/',$str);
        $split_str = 'Recommended Corequisites:';
        if(empty($match)) {
          $match = preg_match('/Recommended Corequisite:/',$str);
          $split_str = 'Recommended Corequisite:';
        }
        if(empty($match)) {
          $match = preg_match('/Recommended corequisites:/',$str);
          $split_str = 'Recommended corequisites:';
        }
        if(empty($match)) {
          $match = preg_match('/Recommended corequisite:/',$str);
          $split_str = 'Recommended corequisite:';
        }

        if($match) {
          $explode = explode($split_str, $str);
          $split = explode('Course Description', $explode[1]);
          $recomm_corequisite = str_replace('Course Description','',$split[0]);

        }

        $match = preg_match('/Prerequisites:Prerequisites:/',$str);
        $split_str = 'Prerequisites:Prerequisites:';
        if(empty($match)) {
          $match = preg_match('/Prerequisites:/',$str);
          $split_str = 'Prerequisites:';
        }
        if(empty($match)) {
          $match = preg_match('/Prerequisite:/',$str);
          $split_str = 'Prerequisite:';
        }
        if($match && empty($recomm_precorequisite) && empty($pre_req)) {
          $explode = explode($split_str, $str);
          $explode = explode('Course Description', $explode[1]);
          $explode = explode('Corequisites', $explode[0]);
          $explode = explode('Corequisite', $explode[0]);
          $explode = explode('Recommended corequisites', $explode[0]);
          $explode = explode('Recommended corequisite', $explode[0]);
          $explode = explode('Recommended Prerequisites', $explode[0]);
          $explode = explode('Recommended Prerequisite', $explode[0]);
          $pre_req = str_replace('Course Description','',$explode[0]);
          $pre_req = str_replace('Corequisites','',$pre_req);
          $pre_req = str_replace('Corequisite','',$pre_req);
          $pre_req = str_replace('Recommended corequisite','',$pre_req);
          $pre_req = str_replace('Recommended','',$pre_req);
          $pre_req = str_replace('Recommended Prerequisites','',$pre_req);
          $pre_req = str_replace('Recommended prerequisite','',$pre_req);
        }

        $match = preg_match('/Corequisite:/',$str);
        $split_str = 'Corequisite:';
        if(empty($match)) {
          $match = preg_match('/Corequisites:/',$str);
          $split_str = 'Corequisites:';
        }
        if($match && empty($recomm_corequisite) && empty($corequisite)) {
          $explode = explode($split_str, $str);
          $split = explode('Course Description', $explode[1]);
          $corequisite = str_replace('Course Description','',$split[0]);

        }


        $match = preg_match('/Knowledge and skills/',$str);
        if(empty($match)) {
          $match = preg_match('/Knowledge and Skills/',$str);
        }
        if(empty($match)) {
          $match = preg_match('/\) Knowledge and skills/',$str);
        }
        if(empty($match)) {
          $match = preg_match('/\. Knowledge and skills/',$str);
        }
        if($match) {
          $result[$course_name][$x++]['content'] = [$course_name, $code,
            $course_req, $credit, $pre_req, $recomm_precorequisite, $corequisite, $recomm_corequisite
          ];
          $i = count($text);
        }

      }
    }
  }

  closedir($handle);
}


$csv_label = array();
fputcsv($file, ['Course name','TSDS PEIMS Code','Course Requirements','Credit', 'Prerequisites','Recommended Prerequisites','Corequisites', 'Recommended Corequisites',
  'Master Course name','Master TSDS PEIMS Code','Master Course Requirements','Master Course credit','Master Prerequisites','Master Recommended Prerequisites','Master Corequisites', 'Master Recommended Corequisites']);
foreach($result as $key => $val) {
  foreach($val as $v) {
    if(in_array($v['content'][1], $check_code)) {
      foreach($compare[$v['content'][1]] as $x => $y) {
        $array = $v['content'];
        $array[] = $y['course_name'];
        $array[] = $y['code'];
        $array[] = $y['course_requirement'];
        $array[] = ' '.$y['credit'];
        $array[] = $y['prerequisite'];
        $array[] = $y['recommended_prerequisites'];
        $array[] = $y['corerequisites'];
        $array[] = $y['recommended_corerequisites'];
        fputcsv($file, $array);
      }
    }
    else {
      fputcsv($file, $v['content']);
    }
  }
}
fclose($file);