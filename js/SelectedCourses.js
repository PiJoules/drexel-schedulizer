var SelectedCourses = (function(){
	var localstorageKey = "schedulizer-schedule";

	var courses = {};
	if (localStorage.getItem(localstorageKey) !== null){
		var stored = JSON.parse(localStorage.getItem(localstorageKey));
		for (var i in stored){
			if (stored[i])
				courses[i] = stored[i];
		}
	}

	var getOverlappingCourses = function(courseObj, schedule){
		var allOverlappingCourses = {};
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
					var day = dayToInt(days[j]);
					var overlappingCourses = schedule.getOverlappingCourses( day, startTime, endTime );
					for (var crn in overlappingCourses){
						allOverlappingCourses[crn] = overlappingCourses[crn];
					}
				}
			}
		}

		return allOverlappingCourses;
	};

	var addCourse = function(crn, courseObj){
		courses[crn] = courseObj;
		localStorage.setItem(localstorageKey, JSON.stringify(courses));
		return true;
	};

	var removeCourse = function(crn){
		delete courses[crn];
		localStorage.setItem(localstorageKey, JSON.stringify(courses));
	};

	var containsCourse = function(crn){
		return (crn in courses);
	};

	var getCourses = function(){
		return courses;
	};

	return {
		addCourse: addCourse,
		containsCourse: containsCourse,
		getOverlappingCourses: getOverlappingCourses,
		getCourses: getCourses,
		removeCourse: removeCourse,
	};
})(); // courses already added to the list