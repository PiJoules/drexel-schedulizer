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

function searchName(){
    var name = $('#name-search input').val().trim();
    if (name !== ""){
        $.get("/search_name.php?name=" + encodeURIComponent(name), function(courses){
            setCoursesTableModal(courses);
        });
    }
}

function searchSubjectAndCode(){
    var subject = $('#serach-subj-and-code .subject input').val().trim();
    var courseNumber = $('#serach-subj-and-code .number input').val().trim();

    if (subject !== "" && courseNumber !== ""){
        var params = $.param({"subject": subject, "number": courseNumber});
        $.get("/search_subject_and_number.php?" + params, function(courses){
            //setCoursesTableModal(courses);
            for (var crn in courses){
                SelectedCourses.addCourse(crn, courses[crn]);
            }
            schedules = schedulesFromSelectedCourses(SelectedCourses.getCourses());
            resetSchedules();
            resetTable();
        }).fail(function (jqXHR, textStatus, error) {
            alert("Post error: " + error);
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
    var selectedCoursesTemplate = Handlebars.compile($("#courses-table-template").html());
    var html = selectedCoursesTemplate({
        courses: SelectedCourses.getCourses()
    });
    $(".selected-courses").html(html);
    $("#courses-table").DataTable({
        //paging: false
    });
    $(".schedules-count").text(schedules.length);
}

function resetSchedules(){
    $("#schedules .schedule").remove();
    for (var i = 0; i < Math.min(schedules.length,2); i++){
        var html = template({
            "credits": schedules[i].getTotalCredits(),
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

/**
 * Get and reformat all days and times into integers as reformattedDays
 */
function reformattedDays(course){
    var days = course["days"];
    var reformattedDays = []; // {day (as int), startTime (int), endTime (int)}
    for (var i in days){
        var dayTime = days[i];
        var dayString = dayTime["day"];
        var timeString = dayTime["time"];

        if (isProperDayString(dayString) && isProperTimeString(timeString)){
            var days2 = dayString.split(""); // M,T,W,R,F
            var times = timeString.split(" - ");
            var startTime = timeToInt(times[0]);
            var endTime = timeToInt(times[1]);

            for (var j = 0; j < days2.length; j++){
                var day = dayToInt(days2[j]);
                reformattedDays.push({
                    "day": day,
                    "startTime": startTime,
                    "endTime": endTime,
                });
            }
        }
    }
    return reformattedDays;
}

function setCoursesTableModal(courses){
    if (Object.keys(courses).length > 0){
        $("#found-courses-table").empty();
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
                        tr2.append($("<tr><td style='width: 39%; text-align: center;'>" + day + "</td><td style='text-align: center;'>" + time + "</td></tr>"));
                    }
                    var td = $("<td><table border='0'><tbody><tr>" + tr2.html() + "</tr></tbody></table></td>");

                    row.append(td);
                }
                else{
                    row.append("<td>" + course[key] + "</td>");
                }
            }
            var td = $("<td><button data-course='" + JSON.stringify(course) + "' type=\"button\" class=\"add-course btn btn-default\"><span class=\"glyphicon glyphicon-plus\"></span></button></td>");
            row.append(td);
            $("#found-courses-table").append(row);
        }

        $(".add-course").click(function(){
            var course = $(this).data("course");
            var crn = course["crn"];

            $(this).toggleClass("btn-default btn-success");
            $(this).find(".glyphicon").toggleClass("glyphicon-plus glyphicon-ok");
        });

        $("#available-courses").modal();
    }
}