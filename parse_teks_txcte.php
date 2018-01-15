
<?php
header('Content-Type: text/html; charset=UTF-8');
require("class.filetotext.php");

$file = fopen("test_lp.csv", 'w');
$file_count = 0;

$result = array();

$compare = [];
$check_code = [];
$entry_array = [];
$read_csv = fopen("teks_tcrc_all.csv", 'r');
while (!feof($read_csv)) {
  $record1 = fgetcsv($read_csv);
  $node_id = $record1[1];
  $code = $record1[2];
  $title = $record1[3];
  if(!isset($compare[$code])) {
    $compare[$code] = [];
  }
  array_push($compare[$code], array('resource_id' => $node_id,'resource_title' => $title));
  $check_code[] = $code;
}

  $check_code = array_unique($check_code);

if ($handle = opendir('doc to convert/test2')) {

  while (false !== ($entry = readdir($handle))) {

    if ($entry != "." && $entry != ".." && $entry != '.DS_Store') {

      $docObj = new Filetotext('doc to convert/test2/'.$entry);
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
          $code = str_replace('Course Credit','',$explode[1]);
        }
        $replace = '';
        $match = preg_match('/. Knowledge and skills/',$str);
        if(empty($match)) {
          $match = preg_match('/\) Knowledge and skills/',$str);
        }
        $replace = 'Knowledge and skills';
        if(empty($match)) {
          $match = preg_match('/\) Knowledge and Skills/',$str);
          $replace = 'Knowledge and Skills';
        }
        if(empty($match)) {
          $match = preg_match('/. Knowledge and Skills/',$str);
          $replace = 'Knowledge and Skills';
        }
        if($match && !$teks_number) {
          if(strpos($str, 'Course Description:') !== FALSE) {
            continue;
          }
          $explode = explode(" ".$replace,$str);
          $teks = $explode[0];
          $teks = str_replace('(c)', '. (c)', $teks);
          $teks = str_replace('  ', ' ', $teks);
          $teks = str_replace('..', '.', $teks);
          $teks = str_replace('. .', '.', $teks);
          $teks = str_replace(' .', '.', $teks);
          $teks_number = $teks;
          $found = 0;
          $entry_array[] = $teks_number;
        }
        preg_match('/\([0-9]*\)[\t]/',$str, $match);
        if(empty($match)) {
          preg_match('/\([0-9]*\)/',$str, $match);
        }
        $braces = false;

        if(empty($match)) {
          preg_match('/[0-9]*\.\s/',$str, $match);
          $braces = true;

        }

        if(isset($match[0]) && $match[0]) {
          $section_number = str_replace("\t",'', $match[0]);
          if($braces) {
            $section_number = str_replace("Minutes",'', $section_number);
            $section_number = str_replace(".",'', $section_number);
            $section_number = trim($section_number);
            $section_number = '('.$section_number.')';
          }
          $found = 1;
        }

        if($found == 1) {
          for($j = $i+1; $j<count($text); $j++) {
            $match = [];
            $sub_string = $text[$j];
            preg_match('/\([A-Z]\)\s/i',$sub_string, $match);
            if(empty($match)) {
              preg_match('/\([A-Z]\)\s\s\s\s\s/',$sub_string, $match);
            }
            preg_match('/\([a-z]*\)\s/',$sub_string, $match2);
            if(empty($match2)) {
              preg_match('/\([a-z]*\)\s\s\s\s\s/',$sub_string, $match2);
            }
            if(isset($match[0]) && $match[0]) {
              $item_number = str_replace("\t",'', $match[0]);
              $result[$entry][$x++]['content'] = [$course_name, $code,
                $unit_number, $unit_name, $teks_number,
                $section_number . $item_number,
                $teks_number . $section_number . $item_number
              ];
              $write = true;
            }
            else if(isset($match2[0]) && $match2[0]) {
              $sub_item_number = str_replace("\t",'', $match2[0]);
              $write = true;
            }
            else {
              $match = preg_match('/Copyright/',$sub_string);
              if($match) {
                $j = count($text);
                $write = true;
              }
              if(!$write && empty($match)) {
                preg_match('#\((.*?)\)#', $section_number, $match_number);
                if($match_number[1]) {
                  $number= "(".$match_number[1].")()";
                  $result[$entry][$x++]['content'] = [$course_name, $code,
                    $unit_number, $unit_name, $teks_number,
                    $number,
                    $teks_number . $section_number
                  ];
                }
              }

              $j = count($text);
              $found = 0;
            }
          }
        }

        $match = preg_match('/Copyright/',$str);
        if($match) {
          $i = count($text);
        }

        preg_match('/Unit [0-9]*\:/',$str, $match);
        if(empty($match)) {
          preg_match('/Section [0-9]*\:/',$str, $match);
        }
        if(empty($match)) {
          preg_match('/Unit [0-9]*\./',$str, $match);
        }
        if(empty($match)) {
          preg_match('/FAKE [0-9]*\./',$str, $match);
        }
        if($match) {
          $unit_number = str_replace(':','',$match[0]);
          $find_unit_name = explode($match[0],$str);
          $unit_name = trim($find_unit_name[1]);
          $unit_name = str_replace('. ', '', $unit_name);
          $unit_name = str_replace('FAKE ', '', $unit_name);
          $next_line = $text[$i+1];
          if($next_line) {
            $unit_name = $unit_name . $next_line;
          }
        }
      }
    }
  }

  closedir($handle);
}
/*

$csv_label = array();
fputcsv($file, ['Course name','TSDS PEIMS Code','Unit/Section #','Unit/Section name','TEKS Chapter','TEKS', 'TEKS code', 'Resource ID',	'Lesson Plan Name']);
foreach($result as $key => $val) {
  foreach($val as $v) {
    $check_tek = trim($v['content'][6]);
    $check_tek = str_replace(')(', '.', $check_tek);
    $check_tek = str_replace('(', '', $check_tek);
    $check_tek = str_replace(')', '', $check_tek);
    $check_tek = str_replace(' ', '', $check_tek);
    if(in_array($check_tek, $check_code)) {
      foreach($compare[$check_tek] as $x => $y) {
        $array = $v['content'];
        $array[] = $y['resource_id'];
        $array[] = $y['resource_title'];
        fputcsv($file, $array);
      }
    }
    else {
      array_pop($v['content']);
      fputcsv($file, $v['content']);
    }
  }
}
*/
fclose($file);

foreach($result as $key => $val) {
  foreach($val as $v) {
    if($v['content'][2]) {
      $name = $v['content'][3];
      if (preg_match('/[^A-Za-z0-9\:\,\-\/\(\)\.\' ]+/i',$name)){
          echo '<br />' . $v['content'][2] . ': ' . $v['content'][3];
      }    
    }
  }
}

