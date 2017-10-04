<?php
	$servername = "localhost";
	$username = "root";
	$password = "root";

	// Create connection
	$conn = new mysqli($servername, $username, $password,'tea_database');

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$handle = fopen('nid.csv', 'r');
	if (!$handle) {
		continue;
	}
	fgetcsv($handle);

	$i = 0;
	while(! feof($handle)) {
		$record = fgetcsv($handle);
		$node = $record[0];

	   // $output_filename = urldecode($path['basename']);

		$sql = "select uri from node n join node__field_document d on n.nid = d.entity_id join file_managed fm on d.field_document_target_id = fm.fid where n.nid='$node' ";
		$result = $conn->query($sql);
		while($row2 = $result->fetch_assoc()) {
		  $uri = $row2['uri'];
		  $baseurl = $node . '_' . basename($uri);
		  $uri = str_replace("public://", "http://tea.debugme.in/sites/default/files/", $uri);

		    if(!file_exists('dropbox/'.$baseurl)) {
		    	//$host = $record[14];
		    	$host = $uri;
			    $ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL, $host);
			    curl_setopt($ch, CURLOPT_VERBOSE, 1);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
			    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			    curl_setopt($ch, CURLOPT_HEADER, 0);
			    $ch_result = curl_exec($ch);
			    curl_close($ch);

			    // the following lines write the contents to a file in the same directory (provided permissions etc)
		    
			    $fp = fopen('dropbox/'.$baseurl, 'w');
			    fwrite($fp, $ch_result);
			    fclose($fp);	
			    echo $node . '<br />';    	
		    }
		}
	}

	fclose($handle);

?>