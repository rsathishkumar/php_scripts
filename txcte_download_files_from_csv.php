<?php

	$handle = fopen('lesson_plan_file_to_download.csv', 'r');
	if (!$handle) {
		continue;
	}

	$i = 0;
	while(! feof($handle)) {
		$record = fgetcsv($handle);
		$id = $record[0];
		$node = $record[1];
		if(empty($record[2])) {
			continue;
		}
		$path = pathinfo($record[2]);
//		$path = pathinfo($record[14]);


//	    $output_filename = $record[1];
//		$output_filename = $record[12];

	    $output_filename = urldecode($path['basename']);
	    $output_filename = $node.'____'.$output_filename;

	    $folder = 'txcte/test';

	    if(!in_array($path['extension'], array('docx','doc','DOCX','DOC'))) {
	    	continue;
	    }

	    if(!file_exists($folder . '/'.$output_filename) || filesize($folder . '/'.$output_filename) == 0) {
	    	//$host = $record[14];
	    	$host = $record[2];
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $host);
		    curl_setopt($ch, CURLOPT_VERBOSE, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
		    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		    curl_setopt($ch, CURLOPT_HEADER, 0);
		    $result = curl_exec($ch);

			/* Check for 404 (file not found). */
		//	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
		//	if($httpCode == 404) {
		//	    echo $id . "----" . $node_id . '----' . $host . '<br />';
		//	}


		    curl_close($ch);

		    // the following lines write the contents to a file in the same directory (provided permissions etc)
	    
		    $fp = fopen($folder . '/'.$output_filename, 'w');
		    fwrite($fp, $result);
		    fclose($fp);	
		//    echo $node . '<br />';    	
	    }

	}

	fclose($handle);

?>