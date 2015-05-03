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
            @media (min-width: 992px){
                .modal-lg {
                    width: 90%;
                }
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
                            <h1 class="page-header">Add Classes</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Find a Class</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Quarter/Semester</label>
                                                <select id="quarter" class="form-control">
                                                    <?php foreach ($quarters as $i => $quarter) { ?>
                                                        <option <?php if ($i == 0) { ?>selected="selected"<?php } ?> ><?php echo $quarter["term"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>CRN of class to add</label>
                                                <div id="crn-search" class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search for...">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Add</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Name of class to find</label>
                                                <div id="name-search" class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search for...">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Search</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div id="serach-subj-and-code" class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="subject form-group">
                                                        <label>Subject code</label>
                                                        <input type="text" class="form-control" placeholder="Search for...">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="number form-group">
                                                        <label>Course Number</label>
                                                            <input type="text" class="form-control" placeholder="Search for...">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button class="btn btn-default" type="button">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Remove a Class</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>CRN of class to remove</label>
                                                <div id="crn-remove" class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search for...">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Remove</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="btn-group">
                                                <button id="remove-all" type="button" class="btn btn-default">Remove All Classes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Selected Courses</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="selected-courses"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Possible Schedules (<span class="schedules-count">0</span>)</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div id="schedules" class="col-lg-12"></div>
                                    </div>
                                    <hr>
                                    <div class="well">
                                        <p>Click to view all the schedules that can be made from these courses</p>
                                        <a class="btn btn-lg btn-default btn-block">View All Possible Schedules (<span class="schedules-count">0</span>)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->


        <div class="modal fade" id="available-courses">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Courses</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped">
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
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="found-courses-table"></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="select-all btn btn-default">Select All</button>
                        <button type="button" class="deselect-all btn btn-default">Deselect All</button>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript" src="../js/handlebars-v3.0.1.js"></script>
        <script id="entry-template" type="text/x-handlebars-template">
            <div class="schedule col-lg-6">
                <table class="schedule{{num}} table table-bordered table-striped">
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
        <script id="courses-table-template" type="text/x-handlebars-template">
            <table id="courses-table" class="table table-bordered table-striped">
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
                <tbody>
                    {{#each courses}}
                        <tr>
                            <td>{{this.subjectCode}}</td>
                            <td>{{this.courseNumber}}</td>
                            <td>{{this.instructionType}}</td>
                            <td>{{this.instructionMethod}}</td>
                            <td>{{this.section}}</td>
                            <td><a target="_blank" href="{{this.details.link}}">{{this.crn}}</a></td>
                            <td>{{this.courseTitle}}</td>
                            <td>
                                <table border='0'>
                                    <tbody>
                                        <tr>
                                        {{#each this.days}}
                                            <tr>
                                                <td style='width: 39%; text-align: center;'>{{this.day}}</td>
                                                <td style='text-align: center;'>{{this.time}}</td>
                                            </tr>
                                        {{/each}}
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>{{this.instructor}}</td>
                        </tr>
                    {{/each}}
                </tbody>
            </table>
        </script>


        <!-- jQuery -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>

        <script type="text/javascript" src="../js/Schedule.js"></script>
        <script type="text/javascript" src="../js/SelectedCourses.js"></script>
        <script type="text/javascript" src="../js/scheduleCreate.js"></script>
        <script type="text/javascript" src="../js/misc_functions.js"></script>
        <script type="text/javascript">
            var courses = SelectedCourses.getCourses();
            var schedules = schedulesFromSelectedCourses(courses);

            var source = $("#entry-template").html();
            var template = Handlebars.compile(source);
            $(".schedules-count").text(schedules.length);

            resetSchedules();
            resetTable();

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
            $('#name-search').keypress(function (e) {
                if (e.which == 13) {
                    searchName();

                    e.preventDefault();
                    return false;
                }
            });
            $("#name-search .btn").click(function(){
                searchName();
            });
            $('#serach-subj-and-code').keypress(function (e) {
                if (e.which == 13) {
                    searchSubjectAndCode();

                    e.preventDefault();
                    return false;
                }
            });
            $("#serach-subj-and-code .btn").click(function(){
                searchSubjectAndCode();
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
            $("#remove-all").click(function(){
                var courses = SelectedCourses.getCourses();
                for (var crn in courses){
                    SelectedCourses.removeCourse(crn);
                }
                schedules = schedulesFromSelectedCourses(SelectedCourses.getCourses());
                resetSchedules();
                resetTable();
            });

            $("#available-courses .select-all").click(function(){
                $("#available-courses .add-course").removeClass("btn-default").addClass("btn-success");
                $("#available-courses .add-course .glyphicon").removeClass("glyphicon-plus").addClass("glyphicon-ok");
            });
            $("#available-courses .deselect-all").click(function(){
                $("#available-courses .add-course").removeClass("btn-success").addClass("btn-default");
                $("#available-courses .add-course .glyphicon").removeClass("glyphicon-plus").addClass("glyphicon-ok");
            });
        </script>

    </body>

</html>
