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

	$handle = fopen('old_node.csv', 'r');
	if (!$handle) {
		continue;
	}
	fgetcsv($handle);
	$list = [];

	$i = 0;
	while(! feof($handle)) {
		$record = fgetcsv($handle);
		$node = $record[0];
		if(empty($node)) { continue; }
	   // $output_filename = urldecode($path['basename']);
		$sql = "select field_document_url_uri from node__field_document_url where entity_id = '".$node."'";
		$result = $conn->query($sql);
		$array_id = [];
		$tmp = '';
		while($row2 = $result->fetch_assoc()) {
			$path = pathinfo($row2['field_document_url_uri']);
			echo '<br />'.$node.'----'.$row2['field_document_url_uri'] . '----'.$path['extension'];
		}
	}

	fclose($handle);


?>