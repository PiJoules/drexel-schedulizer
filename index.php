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
			<div class="row">
				<label>Schedule</label>
				<table id="schedule" class="table table-bordered"></table>
			</div>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

		<script type="text/javascript" src="handlebars-v3.0.1.js"></script>
		<script id="entry-template" type="text/x-handlebars-template">
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
		    	{{#each this}}
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
		</script>

		<script type="text/javascript">
			console.log($("#quarter option[selected]").val());

			var source = $("#entry-template").html();
			var template = Handlebars.compile(source);

			/**
			 * Days: 0(M),1(T),2(W),3(R),4(F)
			 */
			
			var Schedule = (function(){
				/**
				 * Takes a proper day, time, and course, and adds it to the schedule
				 * Returns the schedule in as a JSON array
				 */

				var weeklySchedule = [];
				for (var i = 0; i < 5; i++){
					weeklySchedule[i] = false;
				}

				var dailySchedule = []; // fill schedule with 28 possible slots (28 because 8:00 am - 10:00 pm with half hour increments)
				for (var i = 0; i < 28; i++){
					dailySchedule[i] = weeklySchedule.slice(0);
				}

				var allPossibleSchedules = []; // in case of overlapping classes, make multiple ones

				var courseDoesOverlap = function(day, startTime, endTime){
					for (var t = startTime; t < endTime; t++){
						if (dailySchedule[t][day]){
							return true;
						}
					}
					return false;
				}

				// accepts day as int from 0-4 and time as int from 0-27
				var add = function(day, startTime, endTime, courseObj){
					for (var t = startTime; t < endTime; t++){
						dailySchedule[t][day] = courseObj["courseTitle"];
					}
				};

				var getJSON = function(){
					return dailySchedule;
				};

				// num will be int from 0 to 27
				var numToTime = function(num){
					var hour = Math.floor(num/2) + 8; // start at 8 o'clock
					var ampm = (hour >= 12 ? "pm" : "am");
					hour %= 12;
					if (hour == 0)
						hour = 12;
					if (hour < 10)
						hour = "0" + hour; // pad a zero to make 2 digits
					var min = (num % 2 == 0 ? "00" : "30");
					return hour + ":" + min + " " + ampm;
				};

				var getTableJSON = function(){
					var prettyDailySchedule = [];
					for (var i = 0; i < dailySchedule.length; i++){
						var week = [numToTime(i)];
						week = week.concat(dailySchedule[i]);
						/*for (var j = 0; j < dailySchedule[i].length; j++){
							week.push(dailySchedule[i][j]);
						}*/
						prettyDailySchedule.push(week);
					}
					return prettyDailySchedule;
				};
				
				return {
					add: add,
					getJSON: getJSON,
					getTableJSON: getTableJSON,
					courseDoesOverlap: courseDoesOverlap,
				};
			})();

			var html = template(Schedule.getTableJSON());
			$("#schedule").html(html);

			var SelectedCourses = (function(){
				var courses = {};

				var isProperDayString = function(dayString){
					// the only valid characters
					// other possible dayStrings are "TBD" and "Final"
					return /^[MTWRF]+$/.test(dayString);
				};

				var isProperTimeString = function(timeString){
					return /^\d{2}:\d{2} (am|pm) - \d{2}:\d{2} (am|pm)$/.test(timeString);
				};

				// hours will range from 08(am)-10(pm) and min will either be 00,20,30,50 
				var timeToInt = function(time){
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
				};

				var dayToInt = function(day){
					switch (day){
						case "M": return 0;
						case "T": return 1;
						case "W": return 2;
						case "R": return 3;
						case "F": return 4;
					}
				};

				// return true if successfully added course, false otherwise
				var addCourse = function(crn, courseObj){
					var days = courseObj["days"];
					for (var i in days){
						var dayTime = days[i];
						var dayString = dayTime["day"];
						var timeString = dayTime["time"];

						if (isProperDayString(dayString) && isProperTimeString(timeString)){
							var days = dayString.split(""); // M,T,W,R,F
							var times = timeString.split(" - ");
							var startTime = timeToInt(times[0]);
							var endTime = timeToInt(times[1]);

							for (var j = 0; j < days.length; j++){
								var day = days[j];
								if (Schedule.courseDoesOverlap( dayToInt(day), startTime, endTime )){
									alert("This course overlaps with another course.");
									return false;
								}
							}

							days.forEach(function(day){
								Schedule.add(dayToInt(day), startTime, endTime, courseObj);
							});
						}
					}

					courses[crn] = courseObj;
					return true;
				};

				var containsCourse = function(crn){
					return (crn in courses);
				};

				return {
					addCourse: addCourse,
					containsCourse: containsCourse,
				};
			})(); // courses already added to the list

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

			function searchCRN(){
				var crn = $('#crn-search input').val().trim();
				if (crn !== "" && !SelectedCourses.containsCourse(crn)){
					$.get("/get_course.php?crn=" + crn, function(course){
						if (!SelectedCourses.addCourse(course["crn"], course)){
							return;
						}

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

						var html = template(Schedule.getTableJSON());
						$("#schedule").html(html);

						console.log(course);
					});
				}
			}
		</script>
	</body>
</html>