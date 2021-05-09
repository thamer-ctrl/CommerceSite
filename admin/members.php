<?php 


    session_start();
    $pageTitle="Members";  
    #$noNavbar='';

    if(isset($_SESSION['username'])){

        include 'init.php';  
        include "navbar.php";
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // Start Manage Page
        if ($do=='Manage') {//manage page 

            $query ='';

            if (isset($_GET['page']) && $_GET['page']=='Pending') {
                $query='AND RegStatus = 0';
            }

            $value="thamer";
            checkItem("Username","users",$value);
        
        // Select all users except admin
        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1 $query");

        // Execute the statement
        $stmt->execute();

        // Assign to variable
        $rows = $stmt->fetchAll();
        
        ?>
            <h1 class="text-center">Manage Page </h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                                <td>#ID</td>
                                <td>Usernam</td>
                                <td>Email</td>
                                <td>Full Name</td>
                                <td>Registerd Date</td>
                                <td>Control</td>
                            </tr>
                            <?php
                                foreach ($rows as $row ) {  
                                    echo "<tr>";
                                        echo "<td>" . $row['UserID'] . "</td>";
                                        echo "<td>" . $row['Username'] . "</td>";
                                        echo "<td>" . $row['Email'] . "</td>";
                                        echo "<td>" . $row['FullName'] . "</td>";
                                        echo "<td>" . $row['Date'] . "</td>";
                                        //echo "<td></td>";
                                        echo "<td>
                                            <a href='members.php?do=Edit&userid=". $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                            <a href='members.php?do=Delete&userid=".$row['UserID']."' class='btn btn-danger confirm'>Delete</a>";
                                            if ($row['RegStatus']==0) {
                                                echo "<a href='members.php?do=Activate&userid=".$row['UserID']."' class='btn btn-info activate'>Activate</a>";
                                            }
                                        
                                        
                                        echo  "</td>";    
                                    echo "</tr>";
                                }
                            ?>
                            
                    </table>
                    
                </div>
                <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>  Add new members</a>'
            </div>
            
            
    <?php   }elseif ($do =='Add') {// Add Members Page ?>
            
            
            
            <h1 class="container">Add Member</h1>
            <div class="container">
                <form class="form-horizantal" action="?do=Insert" method="POST">
                    <!--Start Username field-->
                    <div class="form-group form-group-lg" >
                        <label class="col-sm-2 control-label">Username</label>
                        <div class="clo-sm-10 col-md-4">
                                <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Logint Into Shop"/>
                        </div>
                    </div>
                    <!--End Username field-->

                    <!--Start Password field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="clo-sm-10 col-md-4">
                                <input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder="Password Must be Hard & complex"/>
                                <i class="show-pass fa fa-eye fa-2x"></i>
                        </div>
                    </div>
                    <!--End Password field-->

                    <!--Start Email field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="clo-sm-10 col-md-4">
                                <input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid"/>
                        </div>
                    </div>
                    <!--End Email field-->

                    <!--Start Fullname field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Fullname</label>
                        <div class="clo-sm-10 col-md-4">
                                <input type="Fullname" name="Fullname" class="form-control" required="required" placeholder="Full Name Appear in Your Profile"/>
                        </div>
                    </div>
                    <!--End Fullname field-->

                    <!--Start submit field-->
                    <div class="form-group form-group-lg">
                        <div class="clo-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add member" class="btn btn-primary btn-lg" required="required"/>
                        </div>
                    </div>
                    <!--End submit field-->

                </form>
                
            </div> 
            <?php 
        }elseif($do == 'Insert'){
            // Insert member page

            

            if ($_SERVER['REQUEST_METHOD']=='POST'){

                echo "<h1 class='text-center'>Insert Member</h1>";

                echo "<div class='container'>";

                //Get variables from the form
                
                $user = $_POST['username'];
                $pass = $_POST['password'];
                $email= $_POST['email'];
                $name = $_POST['Fullname'];
                $hashPass = sha1($_POST['password']);


                
                // Validate the form
                $errors = array();

                if (strlen($user)<4) {
                    $errors[] = "Username cant be less then <strong> 4 characters</strong>";
                }

                if (strlen($user)>20) {
                    $errors[] = "Username cant be more then <strong> 20 characters</strong>";
                }
                if (empty($pass)) {
                    $errors[] = "Password  cant be <strong> empty</strong> ";
                }
                if (empty($user)) {
                    $errors[] = "Username cant be <strong> empty</strong> ";
                }
                if (empty($email)) {
                    $errors[] = "Email cant be <strong> empty</strong>";
                }               
                if (empty($name)) {
                    $errors[] = "class='alert alert-danger'>Name cant be <strong> empty</strong>";
                }

                foreach ($errors as $er ) {
                    echo "<div class='alert alert-danger'>" . $er . "</div> " . "</br>";
                }
                
                if (empty($errors)) {

                // Check if user exist in database
                $check = checkItem("Username","users",$user);
                if($check==1) {
                    $theMsg = "<div class='alert alert-danger'>Sorry the user is exist</div>";
                    redirectHome($theMsg,'back');
                }else{

                // Insert Userinfo in database
                $stmt = $con->prepare("INSERT INTO
                                        users(Username,Password,Email,FullName,RegStatus,Date)
                                        VALUES(:zuser, :zpass, :zmail, :zname,0, now()) ");
                $stmt-> execute(array(
                        'zuser' => $user,
                        'zpass' => $hashPass,
                        'zmail' => $email,
                        'zname' => $name

                ));

                // Echo success message
                $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated' . "</div>";

                redirectHome($theMsg,'back');
                }
            }
                
               

            }else{
                echo "<div class='container'>";
                $theMsg = '<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
                redirectHome($theMsg,'back');
                echo "</div>";
            }
            
            echo "</div>";

        


              
         
        }elseif($do =='Edit'){ //Edit page
        
            //Check if Get request userid is numeric & get the integer value of it
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']):0;

            // Select All Data Depent On This ID
            $check = checkItem('userid','users',$userid);
            $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

            // Execute Query
            $stmt->execute(array($userid));

            // Fetch The Data
            $row= $stmt->fetch(); // row get the data in array

            // The Row Count
            $count = $stmt->rowCount();

            // If there's such ID show the form
            
            if ($count>0) { ?>

                <h1 class="container">Edit Member</h1>
                <div class="container">
                    <form class="form-horizantal" action="?do=Update" method="POST">
                        <input type="hidden" name="userid" value ="<?php echo $userid ?>">
                        <!--Start Username field-->
                        <div class="form-group form-group-lg" >
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="clo-sm-10 col-md-4">
                                    <input type="text" name="username" class="form-control" value="<?php echo $row['Username']?>" autocomplete="off" required="required" />
                            </div>
                        </div>
                        <!--End Username field-->

                        <!--Start Password field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="clo-sm-10 col-md-4">
                                    <input type="hidden" name="oldpassword" value ="<?php echo $row['Password'] ?>">  
                                    <input type="password" name="newpassword" class="form-control" autocomplete="new-password" />
                            </div>
                        </div>
                        <!--End Password field-->

                        <!--Start Email field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="clo-sm-10 col-md-4">
                                    <input type="email" name="email" class="form-control" required="required"/>
                            </div>
                        </div>
                        <!--End Email field-->

                        <!--Start Fullname field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Fullname</label>
                            <div class="clo-sm-10 col-md-4">
                                    <input type="Fullname" name="Fullname" class="form-control" required="required"/>
                            </div>
                        </div>
                        <!--End Fullname field-->

                        <!--Start submit field-->
                        <div class="form-group form-group-lg">
                            <div class="clo-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Save" class="btn btn-primary btn-lg" required="required"/>
                            </div>
                        </div>
                        <!--End submit field-->

                    </form>
                    
                </div> 
        <?php 

        // If there's no shuch ID show Error Message   
            }else{

                echo "<div class='container'>";
                $theMsg = '<div class="alert alert-danger">Theres no such ID</div>';
                redirectHome($theMsg);
                echo "</div>";
            }

        }elseif($do == 'Update'){   //**** Update Page
            echo "<h1 class='text-center'>Update Member</h1>";

            echo "<div class='container'>";

            if ($_SERVER['REQUEST_METHOD']=='POST'){

                //Get variables from the form
                $id = $_POST['userid'];
                $user = $_POST['username'];
                $email = $_POST['email'];
                $name = $_POST['Fullname'];

                //Password trick
                //$pass=empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] : $pass = sha1($_POST['newpassword']); 
                $pass='';
                if (empty($_POST['newpassword'])) {
                    $pass = $_POST['oldpassword'];
                }else{
                    $pass = sha1($_POST['newpassword']);
                }

                // Validate the form
                $errors = array();

                if (strlen($user)<4) {
                    $errors[] = "Username cant be less then <strong> 4 characters</strong>";
                }

                if (strlen($user)>20) {
                    $errors[] = "Username cant be more then <strong> 20 characters</strong>";
                }

                if (empty($user)) {
                    $errors[] = "Username cant be <strong> empty</strong> ";
                }
                if (empty($email)) {
                    $errors[] = "Email cant be <strong> empty</strong>";
                }               
                if (empty($name)) {
                    $errors[] = "class='alert alert-danger'>Name cant be <strong> empty</strong>";
                }

                foreach ($errors as $er ) {
                    echo "<div class='alert alert-danger'>" . $er . "</div> " . "</br>";
                }
                
                if (empty($errors)) {
                // Update the database with this info
                $stmt = $con->prepare('UPDATE users SET Username = ?,Email= ?, FullName = ?,Password=? WHERE UserID=?');
                $stmt-> execute(array($user,$email,$name,$pass,$id));

                // Echo success message
                $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated' . "</div>";
                redirectHome($theMsg);
                }
                
               

            }else{

                $theMsg= "<div class='alert alert-danger'>  Sorry you cant browse this page directly</div>";
                redirectHome($theMsg);
            }

            echo "</div>";
        
        }elseif($do == 'Activate'){   //**** Update Page
            echo "<h1 class='text-center'>Delet Member</h1>";
            echo "<div class='container'>";
            //Check if Get request userid is numeric & get the integer value of it
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']):0;

                // Select All Data Depent On This ID
                $check = checkItem('userid','users',$userid);
                //$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

                // Execute Query
                //$stmt->execute(array($userid));


                // The Row Count
                //$count = $stmt->rowCount();

                // If there's such ID show the form
                
                //if ($stmt->rowCount()>0) {
                    if ($check>0)  {
                    
                    $stmt = $con->prepare("UPDATE users SET RegStatus =1 where UserID =?");
                    $stmt->execute(array($userid));

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated' . "</div>";
                    redirectHome($theMsg);

                }else{
                    $theMsg= "<div class='alert alert-danger'>'This id is not exist'</div>";
                    redirectHome($theMsg);
                }
            echo '</div>';




        }elseif($do='Delete'){ // Delete member page

            echo "<h1 class='text-center'>Delet Member</h1>";

            echo "<div class='container'>";
            //Check if Get request userid is numeric & get the integer value of it
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']):0;

                // Select All Data Depent On This ID
                $check = checkItem('userid','users',$userid);
                //$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

                // Execute Query
                //$stmt->execute(array($userid));


                // The Row Count
                //$count = $stmt->rowCount();

                // If there's such ID show the form
                
                //if ($stmt->rowCount()>0) {
                    if ($check>0)  {
                    
                    $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
                    $stmt->bindParam(":zuser",$userid); // bind the parameter zuser with the new parameter $userid
                    $stmt->execute();

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted' . "</div>";
                    redirectHome($theMsg);

                }else{
                    $theMsg= "<div class='alert alert-danger'>'This id is not exist'</div>";
                    redirectHome($theMsg);
                }
            echo '</div>';


        }


        
    }

    else{

        header('location: index.php');
        exit();
    }
    ?>