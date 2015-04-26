

function schedulesFromSelectedCourses(selectedCourses){
	var schedules = [Schedule()];

	for (var crn in selectedCourses){
		var course = selectedCourses[crn];

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

			for (var j = 0; j < reformattedDays.length; j++){
				var day = reformattedDays[j]["day"];
				var startTime = reformattedDays[j]["startTime"];
				var endTime = reformattedDays[j]["endTime"];

				var overlappingCourses = schedule.getOverlappingCourses(day, startTime, endTime);
				if (Object.keys(overlappingCourses).length > 0){
					for (var crn in overlappingCourses){
						var copiedSchedule = schedule.clone();
						copiedSchedule.remove(crn);
						schedules.push(copiedSchedule);
					}
					continue;
				}
				else {
					schedule.add(day, startTime, endTime, course);
				}
			}
		}

		// remove duplicates
        var temp = {};
        var removeValFromIndex = [];
        for (var i = 0; i < schedules.length; i++){
            var json = JSON.stringify(schedules[i].getJSON());
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

	return schedules;
}