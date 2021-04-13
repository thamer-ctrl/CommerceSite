<?php
    ob_start(); // Output Buffering Start

    session_start();
    
    #$noNavbar='';

    if(isset($_SESSION['username'])){ 
        $pageTitle="Dashboard";
        include 'init.php';
        include "navbar.php";
       

        $latestUsers = 5;       // Number of latest users
        $theLatest = getLatest("*","users","UserID",$latestUsers); // Latest users array

        # Start Dashboard page

       

        ?>
        <div class="container home-stats text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                    Total Members
                    <span> <a href="members.php" ><?php echo countItems('UserID','users') ?></a></span>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="stat st-pending">
                        PendingMembers
                        <span> <a href="members.php?do=Manage&page=Pending">
                        <?php echo checkItem("RegStatus","users",0)?>
                        </a></span>
                        
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="stat st-items">
                        Total Items
                        <span>1500</span>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="stat st-comments">
                        Total Comments
                        <span>3500</span>
                    </div>
                </div>
            
            </div>
        </div>
        <div class="latest">
            <div class="container ">
                <div class="row">
                    <div class="col-sm-6"> 
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-users"></i> Latest Registered Users
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                    <?php 
                                        
                                        foreach ($theLatest as $users) {
                                            echo '<li>';
                                                echo $users['Username']; 
                                                echo '<a href="members.php?do=Edit&userid=' . $users['UserID'] . '">';
                                                    echo'<span class="btn btn-success pull-right">Edit'; 
                                                    if ($users['RegStatus']==0) {
                                                        echo "<a href='members.php?do=Activate&userid=".$users['UserID']."' class='btn btn-info pull-right activate'>Activate</a>";
                                                    }                                                       
                                                    echo '</span>';
                                                echo '</a>';
                                            echo '</li>';
                                        }
                                    ?>
                                </ul>                             
                            </div>
                        </div>
                    </div>  
                    <div class="col-sm-6"> 
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-users"></i>  Latest Items
                            </div>
                            <div class="panel-body">
                            Test
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>

        <?php
        # End Dashboard page
        include $tp1 . "footer.php"; 
        
    }else{

        header('location: index.php');
        exit();
    }

    ob_end_flush();