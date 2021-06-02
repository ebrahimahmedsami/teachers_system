<?php 
    ob_start();

    session_start();
    if(isset($_SESSION['username'])){
        
        $pageTitle = $_SESSION['username'] . ' Profile';
        include 'init.php';

        /* start dashboard page */
        $paidedStudents = countItems('sName','student WHERE sStatus = 0');
        $unpaidedStudents = countItems('sName','student WHERE sStatus = 1');
        $allStudents = countItems('sName','student');

        ?>

        <div class="container text-center paid">
            <h1 class="text-center">Home Page</h1>
            <div class="row">
            <div class="col-sm-4">
                    <div class="all">
                        <h5><i class="fa fa-school"></i> All Students</h5>
                        <span><a href="member.php?do=manage&page=all"><?php echo $allStudents; ?></a></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="paided1">
                        <h5><i class="fa fa-money-bill-alt"></i> Paided Students</h5>
                        <span><a href="member.php?do=manage&page=s_paided"><?php echo $paidedStudents; ?></a></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="paided2">
                        <h5><i class="fa fa-hand-holding-usd"></i> UnPaided Students</h5>
                        <span><a href="member.php?do=manage&page=s_unpaided"><?php echo $unpaidedStudents; ?></a></span>
                    </div>
                </div>
                <div class="col-sm-3 years">
                    <h5><i class="fa fa-user-graduate"></i> Students Years :</h5>
                    <a href="member.php?syear=1"><span class="btn btn-success">First Year</span></a>
                    <a href="member.php?syear=2"><span class="btn btn-success">Second Year</span></a>
                    <a href="member.php?syear=3"><span class="btn btn-success">Third Year</span></a>
                </div>
                <div class="col-sm-9 info">
                <h5><i class="fa fa-user-graduate"></i> Students Numbers :</h5>
                    <span>Number of <strong>first</strong> year <h3><?php 
                        $first_year = countItems('sName','student WHERE sYear = 1');
                        echo $first_year;
                    ?></h3></span>
                    <span>Number of <strong>second</strong> year <h3><?php 
                        $second_year = countItems('sName','student WHERE sYear = 2');
                        echo $second_year;
                    ?></h3></span>
                    <span>Number of <strong>third</strong> year <h3><?php 
                        $third_year = countItems('sName','student WHERE sYear = 3');
                        echo $third_year;
                    ?></h3></span>                
                </div>
            </div>
        </div>

        <?php

        include $tpl . "footer.php";

    }else{
        header('Location: index.php');
        exit();
    }

    ob_end_flush();
?>