

function schedulesFromSelectedCourses(selectedCourses){
	var schedules = [Schedule()];
	selectedCourses.forEach(function(course){
		var days = course["days"];
		var reformattedDays = []; // {day (as int), startTime (int), endTime (int)}
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
					var day = dayToInt(days[j]);
					reformattedDays.push({
						"day": day,
						"startTime": startTime,
						"endTime": endTime,
					});
				}
			}
		}

		for (var i = 0; i < schedules.length; i++){
			var schedule = schedules[i];

			for (var j = 0; j < reformattedDays; j++){
				var day = reformattedDays[j]["day"];
				var startTime = reformattedDays[j]["startTime"];
				var endTime = reformattedDays[j]["endTime"];

				var overlappingCourses = schedule.getOverlappingCourses(day, startTime, endTime);
				if (Object.keys(overlappingCourses).length > 0){
					
				}
				else {
					schedule.add(day, startTime, endTime, course);
				}
			}
		}
	});
}