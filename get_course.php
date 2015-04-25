<?php

header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

if (!isset($_GET["crn"])){
	echo "";
	return;
}

$crn = $_GET["crn"];

$fp = fopen('results.json', 'r');
$quarters = json_decode(fread($fp, filesize("results.json")), true);
fclose($fp);

// layers
// 1 - quarters/semesters
// 2 - colleges
// 3 - subjects
// 4 - courses

$courses = array();
foreach ($quarters as $quarter) {
	foreach ($quarter["colleges"] as $college) {
		foreach ($college["subjects"] as $subject) {
			foreach ($subject["courses"] as $course) {
				$courses[$course["crn"]] = $course;
			}
		}
	}
}

if (array_key_exists($crn, $courses)){
	echo json_encode($courses[$crn]);
	return;
}
else{
	echo "";
	return;
}

?>