<?php

	$handle = fopen('missing_files.csv', 'r');
	if (!$handle) {
		continue;
	}
	$old = array();
	fgetcsv($handle);

	$i = 0;
	while(! feof($handle)) {
		$record = fgetcsv($handle);
		$node = $record[0];
	//	$index = $record[1];
		$path = pathinfo($record[5]);
//		$path = pathinfo($record[14]);


//	    $output_filename = $record[1];
//		$output_filename = $record[12];

	    $output_filename = urldecode($path['basename']);
	//    $output_filename = $node . '_' . $index . '_' . $output_filename;

	    if(!file_exists('files_downloaded/'.$output_filename)) {
	    	if(in_array($node, $old)) {
	    		echo $node . 'skipped <br />';    
	    		continue;
	    	}
	    	//$host = $record[14];
	    	$host = $record[5];
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $host);
		    curl_setopt($ch, CURLOPT_VERBOSE, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
		    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		    curl_setopt($ch, CURLOPT_HEADER, 0);
		    $result = curl_exec($ch);
		    curl_close($ch);

		    // the following lines write the contents to a file in the same directory (provided permissions etc)
	    
		    $fp = fopen('files_downloaded/'.$output_filename, 'w');
		    fwrite($fp, $result);
		    fclose($fp);	
		    echo $node . '<br />';    	
	    }

	}

	fclose($handle);

?>