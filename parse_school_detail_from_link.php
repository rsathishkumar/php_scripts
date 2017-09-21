<?php

	require_once 'simple_html_dom.php';
$url = "https://premium.usnews.com/best-graduate-schools/top-engineering-schools/eng-rankings";
  $file = fopen("crawler.csv", "w");

$result_array = array();
			$body = get_html_content($url);
			$html = new simple_html_dom();
			$html->load('<html>'.$body.'</html>');
			
			foreach($html->find('td.college_name') as $head) {
			    $college_url = $head->find('a', 0)->href;
			    if(!empty($college_url)) {
				  $result_array[] = array('title' => $head->plaintext, 'url' => 'https://premium.usnews.com'.$head->find('a', 0)->href);
				}

			  }

for($x= 2; $x<=4; $x++) {
  $paging_url = $url . '/page+'.$x;
  $body = get_html_content($paging_url);
	$html = new simple_html_dom();
	$html->load('<html>'.$body.'</html>');

	foreach($html->find('td.college_name') as $head) {
	    $college_url = $head->find('a', 0)->href;
	    if(!empty($college_url)) {
		  $result_array[] = array('title' => $head->plaintext, 'url' => 'https://premium.usnews.com'.$head->find('a', 0)->href);
		}
	  }

}


  $array_value = array();
  foreach($result_array as $key => $val) {
	$array_value = array(trim($val['title']), $val['url']);
	fputcsv($file, $array_value);
  }

  fclose($file);

	function get_html_content($url) {
		$fields_string = "username=mcuban777@gmail.com&password=Pratham9)";
		$ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_HEADER, true);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	  curl_setopt($ch, CURLOPT_COOKIE, '__gads=ID=058ad061512fb4cb:T=1496126474:S=ALNI_MaD6V-sTtzlkp9-_YDq6ZwvHdVOPA; __qca=P0-1659284457-1496126490224; _vwo_uuid=22DCAB5A98EA787BD6DEF0789DBCCC75; _vis_opt_exp_278_combi=2; _ceg.s=oqrl5j; _ceg.u=oqrl5j; auth="7PytfZhGt7ZQBIMLlMUtgTV6h0lvSjkgKIWtJyDW7OMPf2zqQuUsC8VkCByzb9kBzy9Uv51RdrgdwRU-faOAKcHZEkLJmXubuviAsqvhYBMFfc1VwRT86Z78_1MXcwoq9qsmOGcSN7_Uj6xM-H2OY9SOenSI9R5JwUokbFEfTDunPJJLo8KjsBouuq9coYfxnFsztUYCDFqIBKz4z-W-6yZMBeWhVCz8MjOlGzbuSCg2begkMPZwG028SSerVkHB.eNqrVkrLLCouic9LzE1VslJQ8lHSUVDKSUQSCQCJZKYAmUaG5hbmRqZAbkl-dmoeSNLYNNEw0dDcwMgwzczEwMDEwtDYzMTCzNDI1MjIIjUpVakWADBWGYU"; tk=35a1a17021f640048136486125228ebe; is_compass_premium=true; c=2180904422; usn_c=2180904422; compstat=comppar; userid=73626c50-fef1-4bac-953c-1d037064b049; JSESSIONID=B2A5185308DA29B189AEAEB5FDD820FA; _vis_opt_s=2%7C; _vwo_uuid_v2=56BD088DDEC9D414B0D2876C2ED40AAE|da0be6fd13119b4c3de7a41a36481ed2; _vis_opt_test_cookie=1; compass-ad-modal-counter=1; position=157; s_cc=true; s_sq=%5B%5BB%5D%5D; __ybotu=j3bicl1fjmun8l1utb; __ybotv=1496200040272; _ga=GA1.2.980193877.1496126471; _gid=GA1.2.1612389100.1496200041; _ceg.s=oqsrc8; _ceg.u=oqsrc8; utag_main=v_id:015c58163b16001caaacd0f95e330407900170710093c$_sn:5$_ss:0$_st:1496201840122$dc_visit:5$_pn:11%3Bexp-session$ses_id:1496197152278%3Bexp-session$dc_event:99%3Bexp-session$dc_region:eu-central-1%3Bexp-session; OX_plg=pm; bc-page-views=121; display-newsletter-interstitial=true; s_fid=1191B64003F16272-1E295278DE44C8DF; _sp_id.26f9=7686863ce7970b90.1496126488.6.1496207691.1496205591; _sp_ses.26f9=*');

	    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

		$result = curl_exec($ch);
		curl_close ($ch);
		$start = stripos($result, "<body");
	    $end = stripos($result, "</body");

	    $body = substr($result,$start,$end-$start);
	    return $body;
	}



function get_html_content_json($url) {
  $fields_string = "username=mcuban777@gmail.com&password=Pratham9)";
  $ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);

  curl_setopt($ch, CURLOPT_HEADER, true);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch, CURLOPT_USERAGENT, $ua);
  curl_setopt($ch, CURLOPT_COOKIE, '__gads=ID=058ad061512fb4cb:T=1496126474:S=ALNI_MaD6V-sTtzlkp9-_YDq6ZwvHdVOPA; __qca=P0-1659284457-1496126490224; userid=e1b8cf64-9628-4a50-9cff-ff8ae0f8a828; _vwo_uuid=22DCAB5A98EA787BD6DEF0789DBCCC75; _vis_opt_exp_278_combi=2; _vis_opt_exp_278_goal_2=1; usn_grad_interstitial=2; _vis_opt_s=6%7C; auth="uMku9O58hbn7k3JJxpfAcu6nms25RmEsbugsBWG6dSA91X9Jefv-gGtgcevt-3-f9K7Fm_ytknc_J17e4PuemrsTKecyzE5M-0l1d6hixHgVHGZNfMXcWdYDo_Aed0NWh8XVGLuNFowv3aTU_gRzaZX0mnsugxw2b3rYniuYAp6Rf7vl7XNCyHCGOjhUrqUtbQaGUaUdpqsCELmBifvy7_2G6icQSBf1Uec2DpV8zDTBQ4w0Emh3oSJDH9oV0SUZ.eNqrVkrLLCouic9LzE1VslJQ8lHSUVDKSUQSCQCJZKYAmUaG5hbmRqZAbkl-dmoeSNLYNNEw0dDcwMgwzczEwMDEwtDYzMTCzNDI1MjIIjUpVakWADBWGYU"; _vwo_uuid_v2=56BD088DDEC9D414B0D2876C2ED40AAE|da0be6fd13119b4c3de7a41a36481ed2; ak_bmsc=E361CA7D9CF656882FB4FC796DCC51A3170BD764B6240000B2674359444B1762~plnfWazDUagtsBTU+8JxXIkJffqTO6P8fpYREj2Mvf3autj05V9FbbcC43nx5tueXCgJEs8y+a071m01lOiyuZsm9mgYztrx8VbdNBTA1un/YwBhzRK9cca8wgUdJs8vn5xV37ZJWmujN3LWNPsvagzgETdd+uR3uow6O0PfVHSy7ExjsDuEyhFsoKwP4Q5h+Q+taCeRn6csGIrXL5UdW0twHzIEixtRGYQKcyy2+V3vo=; OX_plg=swf|shk|pm; bm_sv=E52732E97E32A6110E268C007CE572EB~fBete5EEbk5yWBQHELY7e/c6foTHbJVhzth62I/uqtPUo7YzAw/Dht39A0KumhHwbM8MWwlEYPcelLtWVkCnU88VizJWtM69PkhjcOW5x4J8vg+tMDpU0tSqiEjqlfUW/s9rZ9x0OlNyLEjl6y5LRPGKKurR9z3rlTCdEJdIdMg=; __ybotu=j3b72le4myn5xym5fs; __ybotv=1497589695466; s_cc=true; s_fid=1191B64003F16272-1E295278DE44C8DF; s_sq=%5B%5BB%5D%5D; _ga=GA1.2.980193877.1496126471; _gid=GA1.2.931458774.1497533266; _ceg.s=ormjlr; _ceg.u=ormjlr; utag_main=v_id:015c58163b16001caaacd0f95e330407900170710093c$_sn:24$_ss:0$_st:1497591495338$dc_visit:26$_pn:3%3Bexp-session$ses_id:1497589683259%3Bexp-session$dc_event:3%3Bexp-session$dc_region:eu-central-1%3Bexp-session; bc-page-views=47; display-newsletter-interstitial=true; compass-ad-modal-counter=44; _sp_id.26f9=7686863ce7970b90.1496126488.29.1497593530.1497589726; _sp_ses.26f9=*');

  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_AUTOREFERER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
  //	curl_setopt($ch,CURLOPT_POST, true);
  //	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

  $result = curl_exec($ch);
  $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $body = substr($result, $header_size);

  curl_close ($ch);
  return $body;
}