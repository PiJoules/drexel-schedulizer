<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Drexel Schedulizer - Add Classes</title>

        <!-- Bootstrap Core CSS -->
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

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
            .sorting_asc:after {
                content: "\f0de";
                float: right;
                font-family: fontawesome;
            }
            .sorting_desc:after {
                content: "\f0dd";
                float: right;
                font-family: fontawesome;
            }
            .sorting:after {
                content: "\f0dc";
                float: right;
                font-family: fontawesome;
                color: rgba(50,50,50,.5);
            }
        </style>

    </head>

    <body>

        <div id="wrapper">

            <?php echo file_get_contents("navbar.html"); ?>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">All Possible Schedules (<span class="schedules-count">0</span>)</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="schedule-sort panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Sort by</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="btn-group">
                                                <button type="button" class="credits btn btn-default sorting_desc"><span class="text">Most Credits</span>&nbsp;</button>
                                                <button type="button" class="time btn btn-default sorting"><span class="text">Early Classes</span>&nbsp;</button>
                                                <button type="button" class="breaks btn btn-default sorting"><span class="text">Fewest Breaks</span>&nbsp;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="description panel-footer">Sort by the most or fewest credits that can be taken.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="schedule-filter panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Filter by</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="credits form-group">
                                                <label>Credits</label>
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <button type="button" name="gt" class="type btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">&gt;</button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a name="gt" href="javascript: void(0);">&gt;</a></li>
                                                            <li><a name="lt" href="javascript: void(0);">&lt;</a></li>
                                                            <li><a name="eq" href="javascript: void(0);">=</a></li>
                                                            <li><a name="gteq" href="javascript: void(0);">&gt;=</a></li>
                                                            <li><a name="lteq" href="javascript: void(0);">&lt;=</a></li>
                                                        </ul>
                                                    </div>
                                                    <input type="number" class="num form-control" min="0" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div id="schedules" class="row"></div>

                </div>
            </div>

        </div>

        <script type="text/javascript" src="../js/handlebars-v3.0.1.js"></script>
        <script id="entry-template" type="text/x-handlebars-template">
            <div class="schedule col-lg-12">
                <h3>{{credits}} Credits</h3>
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
        <script type="text/javascript" src="../js/misc_functions.js"></script>
        <script type="text/javascript">
            var courses = SelectedCourses.getCourses();
            var schedules = schedulesFromSelectedCourses(courses);
            var filteredSchedules = $.extend(true, [], schedules); // clone array (deep copy)

            var source = $("#entry-template").html();
            var template = Handlebars.compile(source);

            resetSchedules2();

            $(".schedule-sort .btn").click(function(){
                var desc;

                if ($(this).hasClass("sorting_desc")){
                    $(this).toggleClass("sorting_desc sorting_asc");
                    desc = false;
                }
                else if ($(this).hasClass("sorting_asc")) {
                    $(this).toggleClass("sorting_asc sorting_desc");
                    desc = true;
                }
                else { // .sorting
                    $(".schedule-sort .btn").removeClass("sorting_asc sorting_desc").addClass("sorting");
                    $(this).toggleClass("sorting sorting_desc"); // make desc by default
                    desc = true;
                }

                if ($(this).hasClass("credits")){
                    if (desc){
                        filteredSchedules.sort(function(a,b){
                            return b.getTotalCredits()-a.getTotalCredits();
                        });
                        $(this).find(".text").text("Most Credits");
                    }
                    else {
                        filteredSchedules.sort(function(a,b){
                            return a.getTotalCredits()-b.getTotalCredits();
                        });
                        $(this).find(".text").text("Fewest Credits");
                    }
                    $(this).find(".description").text("Sort by the most or fewest credits that can be taken.");
                }
                else if ($(this).hasClass("time")){
                    if (desc){
                        filteredSchedules.sort(function(a,b){
                            return a.getStartingTime()-b.getStartingTime();
                        });
                        $(this).find(".text").text("Early Classes");
                    }
                    else {
                        filteredSchedules.sort(function(a,b){
                            return b.getStartingTime()-a.getStartingTime();
                        });
                        $(this).find(".text").text("Late Classes");
                    }
                    $(this).find(".description").text("Sort by classes that start early or late.");
                }
                else {
                    if (desc){
                        filteredSchedules.sort(function(a,b){
                            return a.getTotalBreaks()-b.getTotalBreaks();
                        });
                        $(this).find(".text").text("Fewest Breaks");
                    }
                    else {
                        filteredSchedules.sort(function(a,b){
                            return b.getTotalBreaks()-a.getTotalBreaks();
                        });
                        $(this).find(".text").text("Most Breaks");
                    }
                    $(this).find(".description").text("Sort by shchedules with the most or fewest number of breaks in between classes");
                }

                resetSchedules2();
            });

            $('.schedule-filter .credits .num').keypress(function (e) {
                if (e.which == 13) {
                    applyFilters();

                    e.preventDefault();
                    return false;
                }
            });

            $(".schedule-filter .credits .dropdown-menu a").click(function(){
                var type = $(this).attr("name");
                var html = $(this).html();
                $(".schedule-filter .credits .type").attr("name", type).html(html);
            });

            function resetSchedules2(){
                $("#schedules").empty();
                for (var i = 0; i < filteredSchedules.length; i++){
                    var html = template({
                        "credits": filteredSchedules[i].getTotalCredits(),
                        "num": i,
                        "weeks": filteredSchedules[i].getTableJSON()
                    });
                    $("#schedules").append(html);
                }
                $(".schedules-count").text(filteredSchedules.length);
            }

            function applyFilters(){
                var credits = parseInt($('.schedule-filter .credits .num').val());
                if (isNaN(credits)){
                    return;
                }

                filteredSchedules = [];

                // apply credits
                var type = $(".schedule-filter .credits .type").attr("name");
                switch (type){
                    case "gt":
                        for (var i = 0; i < schedules.length; i++){
                            var schedule = schedules[i];
                            if (schedule.getTotalCredits() > credits){
                                filteredSchedules.push($.extend(true, {}, schedule));
                            }
                        }
                        break;
                    case "lt":
                        for (var i = 0; i < schedules.length; i++){
                            var schedule = schedules[i];
                            if (schedule.getTotalCredits() < credits){
                                filteredSchedules.push($.extend(true, {}, schedule));
                            }
                        }
                        break;
                    case "eq":
                        for (var i = 0; i < schedules.length; i++){
                            var schedule = schedules[i];
                            if (schedule.getTotalCredits() == credits){
                                filteredSchedules.push($.extend(true, {}, schedule));
                            }
                        }
                        break;
                    case "gteq":
                        for (var i = 0; i < schedules.length; i++){
                            var schedule = schedules[i];
                            if (schedule.getTotalCredits() >= credits){
                                filteredSchedules.push($.extend(true, {}, schedule));
                            }
                        }
                        break;
                    case "lteq":
                        for (var i = 0; i < schedules.length; i++){
                            var schedule = schedules[i];
                            if (schedule.getTotalCredits() <= credits){
                                filteredSchedules.push($.extend(true, {}, schedule));
                            }
                        }
                        break;
                }

                resetSchedules2();
            }
        </script>

    </body>

</html>
