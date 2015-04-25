<?php

header('Content-Type: text/html; charset=utf-8');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$fp = fopen('../results.json', 'r');
$quarters = json_decode(fread($fp, filesize("../results.json")), true);
fclose($fp);

// layers
// 1 - quarters/semesters
// 2 - colleges
// 3 - subjects
// 4 - courses

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>SB Admin 2 - Bootstrap Admin Theme</title>

        <!-- Bootstrap Core CSS -->
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style type="text/css">

        </style>

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">SB Admin v2.0</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>Read All Messages</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-tasks">
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 1</strong>
                                            <span class="pull-right text-muted">40% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 2</strong>
                                            <span class="pull-right text-muted">20% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 3</strong>
                                            <span class="pull-right text-muted">60% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                <span class="sr-only">60% Complete (warning)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 4</strong>
                                            <span class="pull-right text-muted">80% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Tasks</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-tasks -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> Message Sent
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-tasks fa-fw"></i> New Task
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-alerts -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                                <!-- /input-group -->
                            </li>
                            <li>
                                <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="flot.html">Flot Charts</a>
                                    </li>
                                    <li>
                                        <a href="morris.html">Morris.js Charts</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                            </li>
                            <li>
                                <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="panels-wells.html">Panels and Wells</a>
                                    </li>
                                    <li>
                                        <a href="buttons.html">Buttons</a>
                                    </li>
                                    <li>
                                        <a href="notifications.html">Notifications</a>
                                    </li>
                                    <li>
                                        <a href="typography.html">Typography</a>
                                    </li>
                                    <li>
                                        <a href="icons.html"> Icons</a>
                                    </li>
                                    <li>
                                        <a href="grid.html">Grid</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="#">Second Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Second Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level <span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="#">Third Level Item</a>
                                            </li>
                                            <li>
                                                <a href="#">Third Level Item</a>
                                            </li>
                                            <li>
                                                <a href="#">Third Level Item</a>
                                            </li>
                                            <li>
                                                <a href="#">Third Level Item</a>
                                            </li>
                                        </ul>
                                        <!-- /.nav-third-level -->
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li class="active">
                                <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a class="active" href="blank.html">Blank Page</a>
                                    </li>
                                    <li>
                                        <a href="login.html">Login Page</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Blank</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->


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
                    <label>Schedules (<span id="schedules-count">0</span>)</label>
                    <div id="schedules" class="row">

                    </div>


                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <script type="text/javascript" src="../js/handlebars-v3.0.1.js"></script>
        <script id="entry-template" type="text/x-handlebars-template">
            <div class="schedule col-lg-6">
                <table class="schedule{{num}} table table-bordered">
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
            </div>
        </script>

        <!-- jQuery -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>

        <script type="text/javascript" src="../js/Schedule.js"></script>
        <script type="text/javascript" src="../js/SelectedCourses.js"></script>
        <script type="text/javascript" src="../js/scheduleCreate.js"></script>
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
