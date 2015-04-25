<?php

header('Content-Type: text/plain; charset=utf-8');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once "simple_html_dom.php";
require_once "misc_functions.php";

$baseURL = "https://duapp2.drexel.edu";
$html = makeSimpleHTMLDOM($baseURL . "/webtms_du/app"); // first layer, home page

$terms = $html->find(".term a[href]"); // first layer of links to courses

// for now, only get Summer Quarter 14-15
$temp = array();
foreach ($terms as $term) {
	if ($term->plaintext === "Summer Quarter 14-15")
		array_push($temp, $term);
}
$terms = $temp;

$termLinks = array();

foreach($terms as $term){
	$termLink = html_entity_decode($baseURL . $term->href);

	$termLinkHTML = makeSimpleHTMLDOM($termLink);
	//$subjects = $termLinkHTML->find(".collegePanel .odd a, .collegePanel .even a"); // second layer of links to courses

	// for each term, get the college
	$colleges = $termLinkHTML->find("#sideLeft a"); // second layer of links to each college
	$collegeLinks = array();
	foreach($colleges as $college) {
		$collegeLink = html_entity_decode($baseURL . $college->href);
		$collegeName = html_entity_decode($college->plaintext);

		$collegeLinkHTML = makeSimpleHTMLDOM($collegeLink);
		$subjects = $collegeLinkHTML->find(".collegePanel .odd a, .collegePanel .even a"); // second layer of links to courses

		// for each college, get subject
		$subjectLinks = array();
		foreach($subjects as $subject){
			$subjectLink = html_entity_decode($baseURL . $subject->href);
			$subjectText = html_entity_decode($subject->plaintext);

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
				$instructionType = html_entity_decode($course->children(2)->plaintext);
				$instructionMethod = $course->children(3)->plaintext;
				$section = $course->children(4)->plaintext; // 061, 601, A, B, etc.
				$crn = intval($course->children(5)->plaintext);
				$courseTitle = html_entity_decode($course->children(6)->plaintext);
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
			/*$fp = fopen('results.json', 'w');
			fwrite($fp, json_encode($coursesInfo, JSON_PRETTY_PRINT));
			fclose($fp);
			var_dump($coursesInfo);
			return;*/

			$subjectLinkArray = array(
				"link" => $subjectLink,
				"subject" => $subjectText,
				"courses" => $coursesInfo
			);
			array_push($subjectLinks, $subjectLinkArray);
		}
		/*$fp = fopen('results.json', 'w');
		fwrite($fp, json_encode($subjectLinks, JSON_PRETTY_PRINT));
		fclose($fp);
		var_dump($subjectLinks);
		return;*/

		$collegeLinkArray = array(
			"link" => $collegeLink,
			"college" => $collegeName,
			"subjects" => $subjectLinks
		);
		array_push($collegeLinks, $collegeLinkArray);
	}
	/*$fp = fopen('results.json', 'w');
	fwrite($fp, json_encode($collegeLinks, JSON_PRETTY_PRINT));
	fclose($fp);
	var_dump($collegeLinks);
	return;*/

	$termLinkArray = array(
		"link" => $termLink,
		"term" => $term->plaintext,
		"colleges" => $collegeLinks
	);
	array_push($termLinks, $termLinkArray);
}
$fp = fopen('results.json', 'w');
fwrite($fp, json_encode($termLinks, JSON_PRETTY_PRINT));
fclose($fp);
var_dump($termLinks);

?>