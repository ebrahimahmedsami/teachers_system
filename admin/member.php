<?php

    ob_start();
    session_start();
    $pageTitle = '';
    if (isset($_SESSION['username'])) {
        include 'init.php';

        $do = isset($_GET['do']) ?  $_GET['do'] : 'manage';

        if ($do == 'manage') {
             //manage student page
            //to get the student paided
            $query = '';
            if (isset($_GET['page']) && $_GET['page'] == 'paid') {
                $sid = $_GET['sid'];
                //update student the status
                $stmt = $con->prepare("UPDATE student SET sStatus = 0 WHERE sID = ? LIMIT 1");
                $stmt->execute(array($sid));
                header("Location: home.php");
                exit();
            }
            if (isset($_GET['page']) && $_GET['page'] == 's_paided') {
                $query = 'OR sStatus = 0';
            }
            if (isset($_GET['page']) && $_GET['page'] == 's_unpaided') {
                $query = 'OR sStatus = 1';
            }
            if (isset($_GET['page']) && $_GET['page'] == 'all') {
                $getsyear = 'sID > 0';
                $query = 'OR sStatus >= 0';
            }
             //select all students
             $getsyear = 0;
             if (isset($_GET['syear'])) {
                $getsyear = $_GET['syear'];
             }
             $stmt = $con->prepare("SELECT * FROM student Where sYear = ? $query");
             $stmt->execute(array($getsyear));
             $row = $stmt->fetchAll();
             ?>

            <h1 class="text-center">Manage Students</h1>
            <?php 
                if ($getsyear == 1) {
                    echo '<h4 class="text-center">First Year</h4>';
                }elseif($getsyear == 2){
                    echo '<h4 class="text-center">Second Year</h4>';
                }elseif($getsyear == 3){
                    echo '<h4 class="text-center">Third Year</h4>';
                }elseif(isset($_GET['page']) && $_GET['page'] == 'all'){
                    echo '<h4 class="text-center">All Years</h4>';
                }
            ?>
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-dark">
                        <thead>
                            <th>#ID</th>
                            <th>Student Name</th>
                            <th>Student Phone</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Paid</th>
                            <th>Year</th>
                            <th>Control</th>
                        </thead>
                        <?php 
                        
                        foreach ($row as $val) {
                           ?>
                            <tr>
                                <td><?php echo $val['sID']; ?></td>
                                <td><?php echo $val['sName']; ?></td>
                                <td><?php echo $val['sPhone']; ?></td>
                                <td><?php echo $val['startDate']; ?></td>
                                <td><?php echo $val['endDate']; ?></td>
                                <td><?php
                                if ($val['sStatus'] == 1) {
                                    echo '<i class="fa fa-times-circle" style="color:red;font-size:20px;"></i>';
                                }else{
                                    echo '<i class="fa fa-check-circle" style="color:green;font-size:20px;"></i>';
                                }
                                      
                                 ?></td>
                                 <td><?php echo $val['sYear']; ?></td>
                                <td>
                                    <a href="member.php?do=sedit&sid=<?php echo $val['sID']; ?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="member.php?do=sdelete&sid=<?php echo $val['sID']; ?>" class="btn btn-danger confirm"><i class="fa fa-trash-alt"></i> Delete</a>
                                    <?php
                                        if ($val['sStatus'] == 1) {
                                            echo '<a href="?page=paid&sid='. $val['sID'] .'" class="btn btn-warning">Paid</a>';
                                        }
                                    ?>
                                </td>
                            </tr>
                           <?php
                        }
                        
                        ?>
                    </table>
                </div>

                <a href="member.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Student</a>
            </div>

             <?php
            ?>
            <?php
            
        }elseif($do == 'add'){
            //add student page
            echo "<h1 class=\"text-center\">Add Student</h1>";
            ?>

                <div class="container">
                    <form class="form-horizontal" action="?do=insert" method="POST">
                    <input type="hidden" name="sid">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Student Name</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="text" name="sname" class="form-control" autocomplete="off" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Student Phone</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="number" name="sphone" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Start Date</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="date" name="startdate" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">End Date</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="date" name="enddate" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Year</label>
                            <div class="col-sm-10 col-lg-4">
                                <div>
                                    <input id="s-first" type="radio" name="syear" value="1" checked> 
                                    <label for="s-first">First</label>
                                </div>
                                <div>
                                    <input id="s-second" type="radio" name="syear" value="2"> 
                                    <label for="s-second">Second</label>
                                </div>
                                <div>
                                    <input id="s-third" type="radio" name="syear" value="3"> 
                                    <label for="s-third">Third</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Student" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>

            <?php

        }elseif($do == 'insert'){

            echo "<h1 class=\"text-center\">Insert Student</h1>";
                
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //get variables from the form
                $sname = $_POST['sname'];
                $sphone = $_POST['sphone'];
                $startdate = $_POST['startdate'];
                $enddate = $_POST['enddate'];
                $syear = $_POST['syear'];

                //check if student exist in database
                $check = checkItem("sName","student",$sname);
                if ($check == 0) {

                //insert new student into database
                $stmt = $con->prepare("INSERT INTO student (sName, sPhone, startDate, endDate, sYear, sStatus)
                VALUES (:sname, :sphone, :startdate, :enddate, :syear, 1)");
                $stmt->execute(array(
                    'sname' => $sname,
                    'sphone' => $sphone,
                    'startdate' => $startdate,
                    'enddate' => $enddate,
                    'syear' => $syear
                )); 

                echo '<div class="alert alert-success">You add new student successfuly</div>';
                header("refresh:2;url=home.php");
                exit();
                }else{
                    echo '<div class="alert alert-danger">This student already exist</div>';
                }
            }else{
                redirectHome("you can not proceed this page directly",5);
            }


        }elseif($do == 'sedit'){
            //update student informayions
            $sid =  isset($_GET['sid']) && is_numeric($_GET['sid']) ? intval($_GET['sid']) : 0;
            
            $stmt = $con->prepare("SELECT * FROM student WHERE sID = ? LIMIT 1");
            $stmt->execute(array($sid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) { ?>
        
                <h1 class="text-center">Edit Student Profile</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=supdate" method="POST">
                    <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Student Name</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="text" name="sname" class="form-control" value="<?php echo $row['sName']; ?>"  autocomplete="off" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Student Phone</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="number" name="sphone" class="form-control" value="<?php echo $row['sPhone']; ?>" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Start Date</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="date" name="startdate" value="<?php echo $row['startDate']; ?>" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">End Date</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="date" name="enddate" value="<?php echo $row['endDate']; ?>" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Year</label>
                            <div class="col-sm-10 col-lg-4">
                                <div>
                                    <input id="s-first" type="radio" name="syear" value="1" required="required"> 
                                    <label for="s-first">First</label>
                                </div>
                                <div>
                                    <input id="s-second" type="radio" name="syear" value="2" required="required"> 
                                    <label for="s-second">Second</label>
                                </div>
                                <div>
                                    <input id="s-third" type="radio" name="syear" value="3" required="required"> 
                                    <label for="s-third">Third</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
        
       <?php 
            }else{
                redirectHome("no such id",4);
            } 


        }elseif($do == 'supdate'){
            //update students page
            echo "<h1 class=\"text-center\">Student informations</h1>";
            echo '<div class="container">';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

               //get variables from the form
               $sid = $_POST['sid'];
               $sname = $_POST['sname'];
               $sphone = $_POST['sphone'];
               $startdate = $_POST['startdate'];
               $enddate = $_POST['enddate'];
               $syear = $_POST['syear'];

                //update student the database
                $stmt = $con->prepare("UPDATE student SET sName = ?,sPhone = ?, startDate = ?, endDate = ?, sYear = ? WHERE sID = ? LIMIT 1");
                $stmt->execute(array($sname,$sphone,$startdate,$enddate,$syear,$sid));
                echo '<div class="alert alert-success">You update student informations successfuly</div>';
                ?>
                <ul class="list-group">
                    <li class="list-group-item active" aria-current="true"><strong>Student informations</strong></li>
                    <li class="list-group-item"><strong>Student Name : </strong><?php echo $sname; ?></li>
                    <li class="list-group-item"><strong>Student Phone : </strong><?php echo $sphone; ?></li>
                    <li class="list-group-item"><strong>Start Date : </strong><?php echo $startdate; ?></li>
                    <li class="list-group-item"><strong>End Date : </strong><?php echo $enddate; ?></li>
                    <li class="list-group-item"><strong>Student Year : </strong><?php echo $syear; ?></li>
                </ul>

                <?php                                

            }else{
                redirectHome("you can not proceed this page directly");
            }
            echo '</div>';

        }elseif($do == 'edit'){
            $userid =  isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            
            $stmt = $con->prepare("SELECT * FROM teacher_profile WHERE ID = ? LIMIT 1");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) { ?>
        
                <h1 class="text-center">Edit Teacher Profile</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=update" method="POST">
                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>"  autocomplete="off" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['password']; ?>">
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="leave it if you don't change password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="text" name="fullname" value="<?php echo $row['fullname']; ?>" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="number" name="phone" value="<?php echo $row['phone']; ?>" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Subject</label>
                            <div class="col-sm-10 col-lg-4">
                                <input type="text" name="subject" value="<?php echo $row['subject']; ?>" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
        
       <?php 
            }else{
                redirectHome("no such id",4);
            } 

        }elseif($do == 'update'){
            echo "<h1 class=\"text-center\">Teacher informations</h1>";
            echo '<div class="container">';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

               //get variables from the form
               $id = $_POST['userid'];
               $username = $_POST['username'];
               $fullname = $_POST['fullname'];
               $phone = $_POST['phone'];
               $subject = $_POST['subject'];
               //password trick

                $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

                //update the database
                $stmt = $con->prepare("UPDATE teacher_profile SET username = ?,password = ?, fullname = ?, phone = ?, subject = ? WHERE ID = ? LIMIT 1");
                $stmt->execute(array($username,$pass,$fullname,$phone,$subject,$id));
                echo '<div class="alert alert-success">Your informations is updated successfuly</div>';
                ?>
                <ul class="list-group">
                    <li class="list-group-item active" aria-current="true"><strong>Your informations</strong></li>
                    <li class="list-group-item"><?php echo $username; ?></li>
                    <li class="list-group-item"><?php echo $fullname; ?></li>
                    <li class="list-group-item"><?php echo $phone; ?></li>
                    <li class="list-group-item"><?php echo $subject; ?></li>
                </ul>

                <?php                                

            }else{
                redirectHome("you can not proceed this page directly");
            }
            echo '</div>';

        }elseif($do == 'sdelete'){
            //delete student page
            ?>
                <h1 class="text-center">Delete Student</h1>
                <div class="container">
            <?php

                $sid =  isset($_GET['sid']) && is_numeric($_GET['sid']) ? intval($_GET['sid']) : 0;
                $check = checkItem("sID","student",$sid);
                

                if ($check > 0) {
                    //delete student from database
                    $stmt = $con->prepare("DELETE FROM student WHERE sID = ?");
                    $stmt->execute(array($sid));
                    echo '<div class="alert alert-success">You deleted the student successfuly</div>';
                    header("refresh:2;url=home.php");
                    exit();
                }else{
                    redirectHome("This id not exist",4);
                }

            ?>
                </div>
            <?php
        }

        include $tpl . 'footer.php';
    
    }else{
        header('Location: index.php');
        exit();
    }
ob_end_flush();
?>