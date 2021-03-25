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

            echo "welclm to  manage";
            echo '<a href="members.php?do=Add">Add new members</a>';
        }elseif ($do =='Add') {// Add Members Page ?>
            
            
            
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
                                <input type="password" name="password" class="form-control" autocomplete="new-password" placeholder="Password Must be Hard & complex"/>
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
                    $errors[] = "<div class='alert alert-danger'>Username cant be less then <strong> 4 characters</strong></div>";
                }

                if (strlen($user)>20) {
                    $errors[] = "<div class='alert alert-danger'>Username cant be more then <strong> 20 characters</strong></div>";
                }

                if (empty($user)) {
                    $errors[] = "<div class='alert alert-danger'>Username cant be <strong> empty</strong></div> ";
                }
                if (empty($email)) {
                    $errors[] = "<div class='alert alert-danger'>Email cant be <strong> empty</strong> </div> ";
                }               
                if (empty($name)) {
                    $errors[] = "<div class='alert alert-danger'>Name cant be <strong> empty</strong>  </div>";
                }

                foreach ($errors as $er ) {
                    echo $er . "</br>";
                }
                
                if (empty($errors)) {
                // Update the database with this info
                $stmt = $con->prepare('UPDATE users SET Username = ?,Email= ?, FullName = ?,Password=? WHERE UserID=?');
                $stmt-> execute(array($user,$email,$name,$pass,$id));

                // Echo success message
                echo "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated' . "</div>";
                }
                
               

            }else{
                echo "Sorry you cant browse this page directly";
            }

            echo "</div>";

        


              
         
        }elseif($do =='Edit'){ //Edit page
        
            //Check if Get request userid is numeric & get the integer value of it
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']):0;

            // Select All Data Depent On This ID
            $stmt = $con->prepare("SELECT * FROM users WHERE GroupID = ? LIMIT 1");

            // Execute Query
            $stmt->execute(array($userid));

            // Fetch The Data
            $row= $stmt->fetch(); // row get the data in array

            // The Row Count
            $count = $stmt->rowCount();

            // If there's such ID show the form
            
            if ($stmt->rowCount()>0) {?>

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
                echo 'Theres no such ID';
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
                    $errors[] = "<div class='alert alert-danger'>Username cant be less then <strong> 4 characters</strong></div>";
                }

                if (strlen($user)>20) {
                    $errors[] = "<div class='alert alert-danger'>Username cant be more then <strong> 20 characters</strong></div>";
                }

                if (empty($user)) {
                    $errors[] = "<div class='alert alert-danger'>Username cant be <strong> empty</strong></div> ";
                }
                if (empty($email)) {
                    $errors[] = "<div class='alert alert-danger'>Email cant be <strong> empty</strong> </div> ";
                }               
                if (empty($name)) {
                    $errors[] = "<div class='alert alert-danger'>Name cant be <strong> empty</strong>  </div>";
                }

                foreach ($errors as $er ) {
                    echo $er . "</br>";
                }
                
                if (empty($errors)) {
                // Update the database with this info
                $stmt = $con->prepare('UPDATE users SET Username = ?,Email= ?, FullName = ?,Password=? WHERE UserID=?');
                $stmt-> execute(array($user,$email,$name,$pass,$id));

                // Echo success message
                echo "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated' . "</div>";
                }
                
               

            }else{
                echo "Sorry you cant browse this page directly";
            }

            echo "</div>";

        }


        


        
    }
    
    
    
    
    else{

        header('location: index.php');
        exit();
    }
    ?>