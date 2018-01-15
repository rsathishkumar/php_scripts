<?php

require("class.filetotext.php");

$file = fopen("test_links.csv", 'w');
$file_count = 0;

$result = array();

$compare = [];
$check_code = [];
$entry_array = [];
$teks_number = [];

if ($handle = opendir('txcte/pdf')) {

  while (false !== ($entry = readdir($handle))) {

    if ($entry != "." && $entry != ".." && $entry != '.DS_Store') {

      $docObj = new Filetotext('txcte/pdf/'.$entry);
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



        preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $str, $matches);

        if($matches[0]) {

          $file_handle = curl_init($matches[0][0]);
          curl_setopt($file_handle,  CURLOPT_RETURNTRANSFER, TRUE);

          /* Get the HTML or whatever is linked in $url. */
          $response = curl_exec($file_handle);

          /* Check for 404 (file not found). */
          $httpCode = curl_getinfo($file_handle, CURLINFO_HTTP_CODE);
          if($httpCode == 404) {
            echo '<br />' . $matches[0][0] . '-----' . $file_id[0];
          }

          curl_close($file_handle);


        }
      }
      //exit;
    }
  }

  closedir($handle);
}


fclose($file);