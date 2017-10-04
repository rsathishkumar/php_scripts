<?php

	$handle = fopen('txcte_files.csv', 'r');
	if (!$handle) {
		continue;
	}

	$i = 0;
	while(! feof($handle)) {
		$record = fgetcsv($handle);
		$node = $record[0];
		if(empty($record[2])) {
			continue;
		}
		$path = pathinfo($record[2]);
//		$path = pathinfo($record[14]);


//	    $output_filename = $record[1];
//		$output_filename = $record[12];

	    $output_filename = urldecode($path['basename']);

	    $folder = 'txcte/Regular Scope and Sequence Files';
	    if(strpos($output_filename, 'Practicum') !== false) {
	    	$folder = 'txcte/Practicum Scope and Sequence Files';
	    }

	    if(!file_exists($folder . '/'.$output_filename)) {
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
		    curl_close($ch);

		    // the following lines write the contents to a file in the same directory (provided permissions etc)
	    
		    $fp = fopen($folder . '/'.$output_filename, 'w');
		    fwrite($fp, $result);
		    fclose($fp);	
		    echo $node . '<br />';    	
	    }

	}

	fclose($handle);

?>