/**
 * Days: 0(M),1(T),2(W),3(R),4(F)
 */

var Schedule = function(initDailySchedule){
	/**
	 * Takes a proper day, time, and course, and adds it to the schedule
	 * Returns the schedule in as a JSON array
	 */

	var dailySchedule = [];
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

	// return object of all courses that share the same time slot with the given a time period
	var getOverlappingCourses = function(day, startTime, endTime){
		var overlappingCourses = {};
		for (var t = startTime; t < endTime; t++){
			var course = dailySchedule[t][day];
			if (course){
				overlappingCourses[course["crn"]] = course;
			}
		}
		return overlappingCourses;
	};

	// accepts day as int from 0-4 and time as int from 0-27
	var add = function(day, startTime, endTime, courseObj){
		for (var t = startTime; t < endTime; t++){
			dailySchedule[t][day] = courseObj;
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
				//week.push(dailySchedule[t][d]["courseTitle"]);
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
		clone: clone,
		isEqual: isEqual,
		isEmpty: isEmpty,
	};
};