<?php

header('Content-Type: text/plain; charset=utf-8');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once "simple_html_dom.php";


$baseURL = "https://duapp2.drexel.edu";
$html = makeSimpleHTMLDOM($baseURL . "/webtms_du/app"); // first layer, home page

$terms = $html->find(".term a[href]"); // first layer of links to courses

$termLinks = array();

foreach($terms as $term){
	$termLink = html_entity_decode($baseURL . $term->href);

	$termLinkHTML = makeSimpleHTMLDOM($termLink);
	$subjects = $termLinkHTML->find(".collegePanel .odd a, .collegePanel .even a"); // second layer of links to courses

	// for each term, get the subject
	$subjectLinks = array();
	foreach($subjects as $subject){
		$subjectLink = html_entity_decode($baseURL . $subject->href);
		$subjectText = $subject->plaintext;

		// for each subject, get the courses
		$subjectLinkHTML = makeSimpleHTMLDOM($subjectLink);
		$subjectLinkHTML->set_callback("removeComments");
		$subjectLinkHTML = str_get_html($subjectLinkHTML . "");
		$courses = $subjectLinkHTML->find("tr.odd, tr.even");
		
		$coursesInfo = array();
		foreach($courses as $i => $course){
			/**
			 * subject code | course no. | instruction type | instruction method | section | crn   | course title                       | days/time             | instructor
			 * -------------------------------------------------------------------------------------------------------------------------------------------------------------
			 * ECEC         | 301        | Lecture          | Face to Face       | 001     | 41331 | Advanced Programming for Engineers | R 06:30 pm - 09:20 pm | STAFF
			 */
			
			// I also catch nested tr tags with "odd" and "even" classes, the ones I want have 9 children that are td tags
			if (count($course->children()) < 9)
				continue;
			
			$subjectCode = $course->children(0)->plaintext;
			$courseNumber = intval($course->children(1)->plaintext);
			$instructionType = $course->children(2)->plaintext;
			$instructionMethod = $course->children(3)->plaintext;
			$section = $course->children(4)->plaintext; // 061, 601, A, B, etc.
			$crn = intval($course->children(5)->plaintext);
			$courseTitle = $course->children(6)->plaintext;
			$days = daysTableToArray($course->children(7));
			$instructor = $course->children(8)->plaintext;

			$courseInfo = array(
				"subjectCode" => $subjectCode,
				"courseNumber" => $courseNumber,
				"instructionType" => $instructionType,
				"instructionMethod" => $instructionMethod,
				"section" => $section,
				"crn" => $crn,
				"courseTitle" => $courseTitle,
				"days" => $days,
				"instructor" => $instructor
			);

			array_push($coursesInfo, $courseInfo);
		}
		var_dump($coursesInfo);return;

		$subjectLinkArray = array(
			"link" => $subjectLink,
			"subject" => $subjectText,
			"courses" => $coursesInfo
		);
		array_push($subjectLinks, $subjectLinkArray);
	}
	//var_dump($subjectLinks);return;

	$termLinkArray = array(
		"link" => $termLink,
		"term" => $term->plaintext,
		"subjects" => $subjectLinks
	);
	array_push($termLinks, $termLinkArray);
}
var_dump($termLinks);


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