

function schedulesFromSelectedCourses(selectedCourses){
	var schedules = [Schedule()];

	for (var crn in selectedCourses){
		var course = selectedCourses[crn];

		for (var i = 0; i < schedules.length; i++){
			var schedule = schedules[i];
			var overlappingCourses = schedule.getOverlappingCourses(course);

			/*
				check if the schedule already contains this specific course
				by comparing the subj. code, course #, and instr. type
			 */
			var similarCourses = schedule.getSimilarCourses(course);

			if (Object.keys(similarCourses).length > 0){
				var copiedSchedule = schedule.clone();
				for (var crn in similarCourses){
					copiedSchedule.remove(crn);
				}
				schedules.push(copiedSchedule);
				continue;
			}
			else if (Object.keys(overlappingCourses).length > 0){
				for (var crn in overlappingCourses){
					var copiedSchedule = schedule.clone();
					copiedSchedule.remove(crn);
					schedules.push(copiedSchedule);
				}
				continue;
			}
			else {
				schedule.add(course);
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

	// by default, sort by total credits
	schedules.sort(function(a,b){
		return b.getTotalCredits()-a.getTotalCredits();
	});

	return schedules;
}