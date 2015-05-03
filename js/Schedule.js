/**
 * Days: 0(M),1(T),2(W),3(R),4(F)
 */

var Schedule = function(initDailySchedule, initDetails){
	/**
	 * Takes a proper day, time, and course, and adds it to the schedule
	 * Returns the schedule in as a JSON array
	 */

	var dailySchedule = [];
	var details = {
		"totalCredits": 0,
		"startingTime": 0,
		"totalBreaks": 0,
	};

	if (typeof initDailySchedule === "undefined"){
		var weeklySchedule = [];
		for (var i = 0; i < 5; i++){
			weeklySchedule[i] = false;
		}

		// fill schedule with 28 possible slots (28 because 8:00 am - 10:00 pm with half hour increments)
		for (var i = 0; i < 28; i++){
			dailySchedule[i] = weeklySchedule.slice(0);
		}
	}
	else {
		dailySchedule = initDailySchedule.slice(0);
	}

	if (typeof initDetails === "object"){
		$.extend(details, initDetails);
	}

	/**
	 * Checks if time of a course overlaps with a course in the current schedule
	 */
	var getOverlappingCourses = function(c){
		var overlappingCourses = {};
		var days = reformattedDays(c);

		for (var i = 0; i < days.length; i++){
			var day = days[i]["day"];
			var startTime = days[i]["startTime"];
			var endTime = days[i]["endTime"];

			for (var t = startTime; t < endTime; t++){
				var course = dailySchedule[t][day];
				if (course){
					overlappingCourses[course["crn"]] = course;
				}
			}
		}

		return overlappingCourses;
	};

	/**
	 * check if the schedule already contains this specific course
	 * by comparing the subj. code, course #, and instr. type
	 * (one is a substring of the other; this is to check for stuff
	 * like 'lecture', 'lab', 'lecture & lab' where you can have a lecture
	 * and a lab, but not a lecture, lab, and 'lecture & lab')
	 */
	var getSimilarCourses = function(c){
		var similarCourses = {};

		var subjectCode = c["subjectCode"];
		var courseNumber = c["courseNumber"];
		var instructionType = c["instructionType"];

		for (var t = 0; t < dailySchedule.length; t++){
			for (var d = 0; d < dailySchedule[t].length; d++){
				var course = dailySchedule[t][d];
				if (course){
					// found an existing course
					var sc = course["subjectCode"];
					var cn = course["courseNumber"];
					var it = course["instructionType"];

					var isSubstring = (instructionType.indexOf(it) > -1 || it.indexOf(instructionType) > -1);
					if (subjectCode === sc && courseNumber === cn && isSubstring){
						//return true;
						similarCourses[course["crn"]] = course;
					}
				}
			}
		}

		//return false;
		return similarCourses;
	};

	var add = function(course){
		var days = reformattedDays(course);
		for (var i = 0; i < days.length; i++){
			var day = days[i]["day"];
			var startTime = days[i]["startTime"];
			var endTime = days[i]["endTime"];

			for (var t = startTime; t < endTime; t++){
				dailySchedule[t][day] = course;
			}
		}
	};

	var remove = function(crn){
		crn = parseInt(crn);
		for (var time = 0; time < dailySchedule.length; time++){
			for (var day = 0; day < dailySchedule[time].length; day++){
				if (dailySchedule[time][day]){
					if (dailySchedule[time][day]["crn"] === crn){
						dailySchedule[time][day] = false;
					}
				}
			}
		}
	};

	var getJSON = function(){
		return dailySchedule;
	};

	var getAllCourses = function(){
		var courses = {};
		for (var time = 0; time < dailySchedule.length; time++){
			for (var day = 0; day < dailySchedule[time].length; day++){
				var course = dailySchedule[time][day];
				if (course){
					courses[course["crn"]] = course;
				}
			}
		}
		return courses;
	};

	var getTotalCredits = function(){
		var courses = getAllCourses();
		var total = 0;
		for (var crn in courses){
			total += courses[crn]["details"]["credits"];
		}
		return total;
	};

	/**
	 * Get total time between first class of each day and 8:00 am
	 */
	var getStartingTime = function(){
		var startingTime = 0;
		for (var d = 0; d < dailySchedule[0].length; d++){
			for (var t = 0; t < dailySchedule.length; t++){
				var course = dailySchedule[t][d];
				if (course){
					// found an existing course
					startingTime += t;
					continue;
				}
			}
		}
		return startingTime;
	};

	/**
	 * Get total number of empty times between the first and last class of each day
	 */
	var getTotalBreaks = function(){
		var totalBreaks = 0;
		for (var d = 0; d < dailySchedule[0].length; d++){
			var start = 0, end = 0;

			// find the first class of day
			for (var t = 0; t < dailySchedule.length; t++){
				var course = dailySchedule[t][d];
				if (course){
					// found an existing course
					start = t;
					break;
				}
			}

			// find last class of day
			for (var t = dailySchedule.length-1; t >= start; t--){
				var course = dailySchedule[t][d];
				if (course){
					// found an existing course
					end = t;
					break;
				}
			}

			// count total number of breaks between start and end times
			for (var t = start+1; t < end; t++){
				var course = dailySchedule[t][d];
				if (!course){
					totalBreaks++;
				}
			}
		}
		return totalBreaks;
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
		var first = 27, last = 0, breakOut = false;
		for (var t = 0; t < dailySchedule.length && !breakOut; t++){
			for (var d = 0; d < dailySchedule[t].length; d++){
				if (dailySchedule[t][d]){
					first = t;
					breakOut = true;
					break;
				}
			}
		}

		breakOut = false;
		for (var t = dailySchedule.length-1; t >= 0 && !breakOut; t--){
			for (var d = 0; d < dailySchedule[t].length; d++){
				if (dailySchedule[t][d]){
					last = t;
					breakOut = true;
					break;
				}
			}
		}

		for (var t = first; t <= last; t++){
			var week = [numToTime(t)];
			for (var d = 0; d < dailySchedule[t].length; d++){
				var course = dailySchedule[t][d];
				if (course){
					var text = course["subjectCode"] + " " + course["courseNumber"];
					week.push(text);
				}
				else {
					week.push("");
				}
			}
			prettyDailySchedule.push(week);
		}

		return prettyDailySchedule;
	};

	var clone = function(){
		var clonedSchedule = [];
		for (var t = 0; t < dailySchedule.length; t++){
			var week = [];
			for (var d = 0; d < dailySchedule[t].length; d++){
				if (typeof dailySchedule[t][d] === "object")
					week.push( $.extend({}, dailySchedule[t][d]) );
				else
					week.push( dailySchedule[t][d] );
			}
			clonedSchedule.push(week);
		}
		var copy = Schedule(clonedSchedule);
		return copy;
	};

	var isEqual = function(schedule){
		return JSON.stringify(dailySchedule) === JSON.stringify(schedule.getJSON());
	};

	var isEmpty = function(){
		for (var time = 0; time < dailySchedule.length; time++){
			for (var day = 0; day < dailySchedule[time].length; day++){
				if (dailySchedule[time][day]){
					return false;
				}
			}
		}
		return true;
	};
	
	return {
		add: add,
		remove: remove,
		getJSON: getJSON,
		getTableJSON: getTableJSON,
		getOverlappingCourses: getOverlappingCourses,
		getSimilarCourses: getSimilarCourses,
		getAllCourses: getAllCourses,
		getTotalCredits: getTotalCredits,
		getStartingTime: getStartingTime,
		getTotalBreaks: getTotalBreaks,
		clone: clone,
		isEqual: isEqual,
		isEmpty: isEmpty,
	};
};