<?php

header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

if (!isset($_GET["subject"]) && !isset($_GET["number"])){
	echo "['nope']";
	return;
}

//echo json_encode(array($_GET["subject"])); return;

$subjectCode = strtoupper($_GET["subject"]);
$number = $_GET["number"];

if (!is_numeric($number)){
	echo "['umm']";
	return;
}
$number = intval($number);


$fp = fopen('results.json', 'r');
$quarters = json_decode(fread($fp, filesize("results.json")), true);
fclose($fp);

// layers
// 1 - quarters/semesters
// 2 - colleges
// 3 - subjects
// 4 - courses

$courses = array();
//echo json_encode(array($subject, $number));return;
foreach ($quarters as $quarter) {
	foreach ($quarter["colleges"] as $college) {
		foreach ($college["subjects"] as $subject) {
			foreach ($subject["courses"] as $course) {
				if (strtoupper($course["subjectCode"]) === $subjectCode && $course["courseNumber"] === $number){
					$courses[$course["crn"]] = $course;
				}
			}
		}
	}
}

echo json_encode($courses);

?>