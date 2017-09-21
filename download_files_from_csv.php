<?php

	$handle = fopen('file to be downloaded1.csv', 'r');
	if (!$handle) {
		continue;
	}
	$old = array('6673','10725','10726','10747','10769','11274','11278','11296','11392','12236','12516','13046','13388','13391','13394','13427','13547','13554','13556','13558','13562','13580','13588','13594','13598','13600','13607','13609','13615','13617','13619','13621','13625','13627','13631','13637','13649','13651','13655','14699','15520','15523','15571');
	fgetcsv($handle);

	$i = 0;
	while(! feof($handle)) {
		$record = fgetcsv($handle);
		$node = $record[0];
		$path = pathinfo($record[2]);
//		$path = pathinfo($record[14]);


	    $output_filename = $record[1];
//		$output_filename = $record[12];

	    $output_filename = urldecode($path['basename']);

	    if(!file_exists('files_downloaded/'.$output_filename)) {
	    	if(in_array($node, $old)) {
	    		echo $node . 'skipped <br />';    
	    		continue;
	    	}
	    	//$host = $record[14];
	    	$host = 'http://tea.debugme.in/'.$record[2];
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