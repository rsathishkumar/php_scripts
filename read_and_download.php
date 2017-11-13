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

	$handle = fopen('page.csv', 'r');
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
		$page_url = str_replace('http://cte.debugme.in','http://cte.sfasu.edu', $node);
		$page_url = str_replace('index.html','',$page_url);
		$sql = "select pl.entity_id, f.uri from node__field_page_link pl join node__field_document d on d.entity_id = pl.entity_id join file_managed f on f.fid = d.field_document_target_id where field_page_link_uri = '".$page_url."'";
		$result = $conn->query($sql);
		$array_id = [];
		$tmp = '';
		while($row2 = $result->fetch_assoc()) {
		  $uri = $row2['uri'];
		  if($uri != $tmp) {
			  $array_id[] = $row2['entity_id'];		
			  $tmp = $uri;  	
		  }
		  
		}
		$list[$node] = $array_id;
	}

	fclose($handle);

	foreach($list as $key => $val) {
		echo $key;
		foreach($val as $k=>$v) {
			echo '----'.$v;
		}
		echo '<br />';
	}

?>