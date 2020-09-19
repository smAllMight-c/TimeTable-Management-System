<?php
include "includes/header.php";
include "includes/sidebar.php";
?>
<?php
    session_start();
    if(isset($_POST['TDP']) && isset($_POST['SEM'])) {
        $_SESSION['dept']=$_POST['TDP'];
        $_SESSION['sem']=$_POST['SEM'];
    }
    else{
    
    $_POST['TDP']=$_SESSION['dept'];
        $_POST['SEM']=$_SESSION['sem'];
    }
?>

<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Assign Course</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Assign Course</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form method="post" action="addtimetable.php">
                                    <div class="row">
                                        <div class="col-md-12">
                                        
                                            <div class="form-group">
                                            <label for="subjectname">Subject Name</label>

                                                <select class="form-control" id="subjectname" name="SN" required >
                                                <?php


                                                include 'connection.php';
                                                $sql="select sname from subjects where did=(select did from department where name='$_SESSION[dept]') and semester='$_SESSION[sem]'";

                                                $ret=pg_query($db,$sql);
                                                if(!$ret) {
                                                echo pg_last_error($db);
                                                exit;
                                                    } 
                                                $string = '<option selected disabled>Select</option>';
                                                while($row = pg_fetch_row($ret)) {
                                                $string .='<option value="'.$row[0].'">'.$row[0].'</option>';
                                                }
                                                echo $string;
                                                pg_close($db);
                                                ?>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">  
                                            <div class="form-group">
                                            <label for="tname">Teachers</label>

                                                            <select class="form-control" id="tname" name="TN" required >
                                                            <?php


                                                            include 'connection.php';
                                                            $sql="select name from teacher where did=(select did from department where name='$_SESSION[dept]')";

                                                            $ret=pg_query($db,$sql);
                                                            if(!$ret) {
                                                            echo pg_last_error($db);
                                                            exit;
                                                                } 
                                                            $string = '<option selected disabled>Select</option>';
                                                            while($row = pg_fetch_row($ret)) {
                                                            $string .='<option value="'.$row[0].'">'.$row[0].'</option>';
                                                            }
                                                            echo $string;
                                                            pg_close($db);
                                                            ?>
                                                                
                                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">  
                                            <div class="form-group">
                                            <label for="classroom">Classroom</label>

                                                            <select class="form-control" id="classroom" name="CR" required >
                                                            <?php


                                                            include 'connection.php';
                                                            $sql="select cno from classroom";

                                                            $ret=pg_query($db,$sql);
                                                            if(!$ret) {
                                                            echo pg_last_error($db);
                                                            exit;
                                                                } 
                                                            $string = '<option selected disabled>Select</option>';
                                                            while($row = pg_fetch_row($ret)) {
                                                            $string .='<option value="'.$row[0].'">'.$row[0].'</option>';
                                                            }
                                                            echo $string;
                                                            pg_close($db);
                                                            ?>
                                                                
                                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">  
                                            <div class="form-group">
                                            <label for="tslot">Time Slot</label>

                                            <select class="form-control" id="tslot" name="TS" required >
                                            <?php


                                            include 'connection.php';
                                            $sql="select * from timeslot";

                                            $ret=pg_query($db,$sql);
                                            if(!$ret) {
                                            echo pg_last_error($db);
                                            exit;
                                                } 
                                            $string = '<option selected disabled>Select</option>';
                                            while($row = pg_fetch_row($ret)) {
                                            $string .='<option value="'.$row[0].'">'.$row[0].'</option>';
                                            }
                                            echo $string;
                                            pg_close($db);
                                            ?>
                                                
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">  
                                            <div class="form-group">
                                            <label for="day">Day</label>
                                        <select class="form-control" id="day" name="DAY" required >
                                            <option value="Monday">Monday</option>
                                            <option value="Tuesday">Tuesday</option>
                                            <option value="Wednesday">Wednesday</option>
                                            <option value="Thursday">Thursday</option>
                                            <option value="Friday">Friday</option>
                                            <option value="Saturday">Saturday</option>
                                        </select>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-12">  
                                            <div class="form-group">
                                               <button class="btn btn-block btn-info rounded-0" name="register">Add Schedule</button> 
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            
                
            
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <table id="basic-datatable" class="table dt-responsive nowrap">
                                <thead>
                                    <tr>
                                    <th scope="col">Day</th>
                                    <th scope="col">Time Slot</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Teacher</th>
                                    <th scope="col">Classroom</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                        
                        include 'connection.php';
                     
                        $dp="'$_SESSION[dept]'";
                        $se="'$_SESSION[sem]'";
                       

                       $sql = "Select * from allot where did=(select did from department where name=$dp ) and semester=$se order by day";
                      
                        $ret = pg_query($db, $sql);
                        if (!$ret) {
                            echo pg_last_error($db);
                            exit;
                        }
                        while ($row = pg_fetch_row($ret)) {
                            $sq= "select sname from subjects where sid=$row[2]";
                            $tq="select name from teacher where tid=$row[3]";

                            $sr=pg_query($db,$sq);
                            $tr=pg_query($db,$tq);

                            $sid = pg_fetch_row($sr);
                            $tid = pg_fetch_row($tr);
                            echo "<tr><th scope=\"row\">{$row[6]}</th>
                        <td>{$row[5]}</td>
                        <td>{$sid[0]}</td>
                        <td>{$tid[0]}</td>
                        <td>{$row[4]}</td>" ?>
                        <td><a href="delete_ttable.php?dept_name=<?php echo $_SESSION['dept']?>&sem=<?php echo $_SESSION['sem']?>&sid=<?php echo $row[2]?>&tid=<?php echo $row[3]?>&day=<?php echo $row[6]?>&tslot=<?php echo $row[5]?>" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a></td                       
                      </tr>
                       <?php
                        }
                        pg_close($db);
                        ?>                                  
                            </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>

        </div> <!-- container -->

    </div> <!-- content -->

    <?php
    include "includes/footer.php";
    ?>