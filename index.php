<?php

header('Content-Type: text/html; charset=utf-8');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$fp = fopen('results.json', 'r');
$quarters = json_decode(fread($fp, filesize("results.json")), true);
fclose($fp);

// layers
// 1 - quarters/semesters
// 2 - colleges
// 3 - subjects
// 4 - courses

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Drexel Schedulizer</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
	</head>
	<body>
		<div class="container">
			<div class="row">
				<label>Quarter/Semester</label>
				<select id="quarter" class="form-control">
					<?php foreach ($quarters as $i => $quarter) { ?>
						<option <?php if ($i == 0) { ?>selected="selected"<?php } ?> ><?php echo $quarter["term"]; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="row">
				<label>CRN of class to add</label>
				<div id="crn-search" class="input-group">
					<input type="text" class="form-control" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Add</button>
					</span>
				</div>
			</div>
			<div class="row">
				<label>CRN of class to remove</label>
				<div id="crn-remove" class="input-group">
					<input type="text" class="form-control" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Remove</button>
					</span>
				</div>
			</div>
			<div class="row">
				<label>Selected</label>
				<table class="table table-bordered">
				    <thead>
				        <tr>
							<th>Subject Code</th>
							<th>Course No.</th>
							<th>Instr Type</th>
							<th>Instr Method</th>
							<th>Sec</th>
							<th>CRN</th>
							<th>Course Title</th>
							<th>Days/Time</th>
							<th>Instructor</th>
				        </tr>
				    </thead>
				    <tbody id="courses-table"></tbody>
				</table>
			</div>
			<div id="schedules" class="row">
				<label>Schedules (<span id="schedules-count">0</span>)</label>
			</div>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

		<script type="text/javascript" src="js/handlebars-v3.0.1.js"></script>
		<script id="entry-template" type="text/x-handlebars-template">
			<table class="schedule schedule{{num}} table table-bordered">
			    <thead>
			        <tr>
			        	<th></th>
						<th>Monday</th>
						<th>Tuesday</th>
						<th>Wednesday</th>
						<th>Thursday</th>
						<th>Friday</th>
			        </tr>
			    </thead>
			    <tbody>
			    	{{#each weeks}}
				    	<tr>
				    		<td>{{this.[0]}}</td>
				    		<td>{{#if this.[1]}} {{this.[1]}} {{/if}}</td>
				    		<td>{{#if this.[2]}} {{this.[2]}} {{/if}}</td>
				    		<td>{{#if this.[3]}} {{this.[3]}} {{/if}}</td>
				    		<td>{{#if this.[4]}} {{this.[4]}} {{/if}}</td>
				    		<td>{{#if this.[5]}} {{this.[5]}} {{/if}}</td>
				    	</tr>
			    	{{/each}}
			    </tbody>
			</table>
		</script>

		<script type="text/javascript" src="js/Schedule.js"></script>
		<script type="text/javascript" src="js/SelectedCourses.js"></script>
		<script type="text/javascript" src="js/scheduleCreate.js"></script>
		<script type="text/javascript">
			var schedules = [Schedule()];

			var source = $("#entry-template").html();
			var template = Handlebars.compile(source);
			$("#schedules-count").text(schedules.length);

			resetSchedules();

			$('#crn-search').keypress(function (e) {
				if (e.which == 13) {
					searchCRN();

					e.preventDefault();
					return false;
				}
			});
			$("#crn-search .btn").click(function(){
				searchCRN();
			});
			$('#crn-remove').keypress(function (e) {
				if (e.which == 13) {
					removeCourse();

					e.preventDefault();
					return false;
				}
			});
			$("#crn-remove .btn").click(function(){
				removeCourse();
			});

			function searchCRN(){
				var crn = $('#crn-search input').val().trim();
				if (crn !== "" && !SelectedCourses.containsCourse(crn)){
					crn = parseInt(crn);
					$.get("/get_course.php?crn=" + crn, function(responseCourse){
						SelectedCourses.addCourse(responseCourse["crn"], responseCourse);
						schedules = schedulesFromSelectedCourses(SelectedCourses.getCourses());
						resetSchedules();
						resetTable();
					});
				}
			}

			function removeCourse(){
				var crn = $('#crn-remove input').val().trim();
				if (crn !== ""){
					crn = parseInt(crn);
					SelectedCourses.removeCourse(crn);
					schedules = schedulesFromSelectedCourses(SelectedCourses.getCourses());
					resetSchedules();
					resetTable();
				}
			}

			function resetTable(){
				$("#courses-table").empty();
				var courses = SelectedCourses.getCourses();
				for (var crn in courses){
					var course = courses[crn];
					var row = $("<tr></tr>");
					for(var key in course){
						if (key === "days"){
							var days = course[key];
							var tr2 = $("<tr></tr>");
							for(var key2 in days){
								var day = days[key2]["day"];
								var time = days[key2]["time"];
								tr2.append($("<td style='width: 39%; text-align: center;'>" + day + "</td><td style='text-align: center;'>" + time + "</td>"));
							}
							var td = $("<td><table border='0'><tbody><tr>" + tr2.html() + "</tr></tbody></table></td>");

							row.append(td);
						}
						else{
							row.append("<td>" + course[key] + "</td>");
						}
					}
					$("#courses-table").append(row);
				}
				$("#schedules-count").text(schedules.length);
			}

			function resetSchedule(i){
				var html = template({
					"num": i,
					"weeks": schedules[i].getTableJSON()
				});
				if ($("#schedules .schedule .schedule" + i).length <= 0)
					$("#schedules").append(html);
				else
					$("#schedules .schedule .schedule" + i).replaceWith(html);

				if (schedules[i].isEmpty() && schedules.length > 1){
					$("#schedules .schedule .schedule" + i).remove();
					schedules.splice(i,1);
				}
			}

			function resetSchedules(){
				$("#schedules .schedule").remove();
				for (var i = 0; i < schedules.length; i++){
					var html = template({
						"num": i,
						"weeks": schedules[i].getTableJSON()
					});
					$("#schedules").append(html);
				}
			}

			function dayToInt(day){
				switch (day){
					case "M": return 0;
					case "T": return 1;
					case "W": return 2;
					case "R": return 3;
					case "F": return 4;
				}
			}

			// hours will range from 08(am)-10(pm) and min will either be 00,20,30,50 
			function timeToInt(time){
				var isPM = (time.indexOf("pm") > -1);
				var hour = parseInt(time.substr(0,2));
				if (isPM && hour !== 12)
					hour += 12;
				hour = (hour-8)*2; // 8:00 am corrsponds to 0, 9:30 pm corresponds to 27
				var min = parseInt(time.substr(3,2));

				// round up to next val if either 20 or 30
				// round up to next hour if 50
				if (min === 20 || min === 30){
					hour++;
				}
				else if (min === 50){
					hour += 2;
				}

				return hour;
			}

			function isProperDayString(dayString){
				// the only valid characters
				// other possible dayStrings are "TBD" and "Final"
				return /^[MTWRF]+$/.test(dayString);
			}

			function isProperTimeString(timeString){
				return /^\d{2}:\d{2} (am|pm) - \d{2}:\d{2} (am|pm)$/.test(timeString);
			}

			function removeDuplicateSchedules(){
				var temp = {};
				var removeValFromIndex = [];
				for (var i = 0; i < schedules.length; i++){
					var schedule = schedules[i];
					var json = JSON.stringify(schedule.getJSON());
					if (json in temp){
						removeValFromIndex.push(i);
					}
					else {
						temp[json] = true;
					}
				}
				for (var i = removeValFromIndex.length-1; i >= 0; i--){
					schedules.splice(removeValFromIndex[i],1);
				}
			}
		</script>
	</body>
</html>