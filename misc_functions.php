<?php

function removeComments($element) {
	// Hide all comments 
	if ($element->tag === 'comment')
		$element->outertext = '';
}

function daysTableToArray($table){
	$days = array();
	foreach($table->find("tr") as $row){
		$day = $row->find("td",0)->plaintext;
		$time = $row->find("td",1)->plaintext;

		array_push($days, array(
			"day" => $day,
			"time" => $time
		));
	}
	return $days;
}

function curlGetPage($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function makeSimpleHTMLDOM($url){
	$html = "";
	if (isOnGAE() || isOnDevServer()){
		$html = file_get_html($url);
	}
	else{
		$html = curlGetPage($url);
		$html = str_get_html($html);
	}
	return $html;
}

function isOnGAE(){
	return isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'],'Google App Engine') !== false;
}

function isOnDevServer(){
	return isset($_SERVER["REQUEST_URI"]);
}

?>