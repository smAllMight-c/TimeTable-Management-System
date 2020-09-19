<?php
include "includes/header.php";
include "includes/sidebar.php";
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
                                <li class="breadcrumb-item active">Time Table</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Time Table</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 
            <form method="post">
            	<div class="form-inline">
				<select name="select_department" class="form-control" id="dept">
				<option disabled="" selected="">--Select Department--</option>
           			 <?php


                    include 'connection.php';
                    $sql="select name from department";
                         $ret=pg_query($db,$sql);
                         if(!$ret) {
                       echo pg_last_error($db);
                         exit;
                             } 
                    while($row = pg_fetch_row($ret)) {
                      $string .='<option value="'.$row[0].'">'.$row[0].'</option>';
                     }
                         echo $string;
                         pg_close($db);
                        ?>
       				 </select>



            		<select name="select_semester" class="form-control">
           				 <option selected disabled>--Select Semester--</option>
           				 <option value="FY">FY</option>
           				 <option value="SY">SY</option>
           				 <option value="TY">TY</option>
      				  </select>
            			<select class="form-control" id="tslot" name="TS"  >
            			<option>--Select TimeSlot--</option>
                                            <?php


                                            include 'connection.php';
                                            $sql="select * from timeslot";

                                            $ret=pg_query($db,$sql);
                                            if(!$ret) {
                                            echo pg_last_error($db);
                                            exit;
												} 
												$string="";
                                            while($row = pg_fetch_row($ret)) {
                                            $string .='<option value="'.$row[0].'">'.$row[0].'</option>';
                                            }
                                            echo $string;
                                            pg_close($db);
                                            ?>
                                                
                                         
            		</select>
            		
					
            		<select class="form-control" id="day" name="DAY"  >
					<option selected disabled>--Select Day--</option>
                                            <option value="Monday">Monday</option>
                                            <option value="Tuesday">Tuesday</option>
                                            <option value="Wednesday">Wednesday</option>
                                            <option value="Thursday">Thursday</option>
                                            <option value="Friday">Friday</option>
                                            <option value="Saturday">Saturday</option>
                                        </select>
            		<button class="btn btn-primary" name="submit">Generate Timetable</button>
            	</div>
            </form>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card-box">
                        <div class="row">
                  	 		<div id="content" class="col-md-12">
							   
                  	 			
                  	 			<table class="table table-bordered content"></center>
								   <thead >
								   <?php
                    
					include 'connection.php';

				   if(isset($_POST['select_department']) && isset($_POST['select_semester'])) {?>
						<center><h2>CLASS TIMETABLE FOR <?php if(isset($_POST['select_department'])){
									   echo $_POST['select_department'];
									   }?> </h2></center>
                  	 				<center><h2>Semester -: <?php if(isset($_POST['select_semester'])){
									   echo $_POST['select_semester'];
									   }?> </h2></center>

                    <th style="text-align:center" scope="col">DAYS</th> 
                    <?php
					$dept=$_POST['select_department'];
						$sem=$_POST['select_semester']; 
                        $dq="select did from department where name='$dept'";
                        $dr=pg_query($db,$dq);
                        $did = pg_fetch_row($dr);

                         $sql="select timeslot from allot where  did=$did[0] and semester='$sem' and day='Monday'";
                         $t=pg_query($db,$sql);
                        $ts=pg_fetch_all($t);
                        for($i=0;$i<count($ts);$i++)
                        {
                            $t= $ts[$i]['timeslot'];
                            echo "<th style=\"text-align:center\" scope=\"col\">$t</th>";
                        }
                     
                     
                     
                     
					   }
					   
					   
                    ?>
					<?php
					 if(isset($_POST['TS']) && isset($_POST['DAY'])) {?>
						<center><h2>SCHEDULE FOR <?php if(isset($_POST['DAY'])){
							echo $_POST['DAY'];
							}?> 
							</h2></center>
							<center><h2>TIMESLOT -: <?php if(isset($_POST['TS'])){
							echo $_POST['TS'];
							}?> </h2></center>
					<?php }
					 ?>

				
                    
					

                   </thead>
                  	 				<tbody>
									   <?php
                    
                    include 'connection.php';

                   if(isset($_POST['select_department']) && isset($_POST['select_semester'])) {
                        $dept=$_POST['select_department'];
                        $sem=$_POST['select_semester'];
                        $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                       $dq="select did from department where name='$dept'";
                       $dr=pg_query($db,$dq);
                       $did = pg_fetch_row($dr);

                        $sql="select timeslot from allot where  did=$did[0] and semester='$sem' and day='Monday'";
                        $t=pg_query($db,$sql);
                       $ts=pg_fetch_all($t);
                       for($j=0;$j< count($days);$j++)
                       {
                        echo "<tr><th>$days[$j]</th>";
                       for($i=0;$i<count($ts);$i++)
                       {
                           $t= $ts[$i]['timeslot'];
                           $s="select sid from allot where did=$did[0] and semester='$sem' and day='$days[$j]' and timeslot='$t'";
                           $st=pg_query($db,$s);
                           $sid=pg_fetch_row($st);
                           $sq= "select sname from subjects where sid=$sid[0]";
                           $sqt=pg_query($db,$sq);
                           $sname=pg_fetch_row($sqt);
                           echo "<td style=\"text-align:center\" scope=\"row\">$sname[0]</td>";
                       }
                       echo "</tr>";
                       }
                    
                    
					  }
					  
					  if(isset($_POST['TS']) && isset($_POST['DAY'])) {?>
						
						<table id="basic-datatable" class="table dt-responsive nowrap">
                                <thead>
                                    <tr>
                                    <th scope="col">Department</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Teacher</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Classroom</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                        
                        include 'connection.php';
                     
                        $dp=$_POST['TS'];
                        $se=$_POST['DAY'];
                       

                       $sql = "Select * from allot where timeslot='$dp' and day='$se'";
                      
                        $ret = pg_query($db, $sql);
                        if (!$ret) {
                            echo pg_last_error($db);
                            exit;
                        }
                        while ($row = pg_fetch_row($ret)) {
                            $sq= "select sname from subjects where sid=$row[2]";
							$tq="select name from teacher where tid=$row[3]";
                            $dq="select name from department where did=$row[0]";
							

                            $sr=pg_query($db,$sq);
							$tr=pg_query($db,$tq);
                            $dr=pg_query($db,$dq);
							

                            $sid = pg_fetch_row($sr);
							$tid = pg_fetch_row($tr);
                            $did = pg_fetch_row($dr);
							
                            echo "<tr><th scope=\"row\">{$did[0]}</th>
                        <td>{$row[1]}</td>
                        <td>{$sid[0]}</td>
                        <td>{$tid[0]}</td>
                        <td>{$row[4]}</td>" ?>
                       
                       <?php
                        }
                        pg_close($db);
                        ?>                                  
                            </tbody>
                            </table>

					
				<?php	}
					 
					  ?>
					  
								</tbody>
							</table>
                        </div>
                    </div> <!-- end card-box-->
                </div>
            </div>
            <button id="cmd" class="btn btn-success cmd">Download Time-Table</button>
    		</div>
		</div>
    </div>
</div> <!-- container -->
</div> <!-- content -->
<?php
include "includes/footer.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
<script>
$(function(){
	let doc = new jsPDF('p','pt','a4');
	$("#cmd").click(function(){
		doc.addHTML(document.getElementById('content'),function() {
    	doc.save('Time-Table.pdf');
		})
	});
  })
 </script>
<style type="text/css">
	.time-text{
		text-align: center;
		font-weight: bold;
	}

	table th{
		text-align: center;
	}
	table tr{
		text-align: center;
		font-weight: bold;
	}
	.content{
		background-color: white !important;
	}

</style>