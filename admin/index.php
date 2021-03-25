<?php
    session_start();
    $noNavbar='';
    $pageTitle="Login";
    if(isset($_SESSION['username'])){
      header('location: dashboard.php');// Redirect to dashboard
    }
    
    include "init.php";
    
    
    // Check if user coming from http Post request

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password); 
        
        //Check if the user exit in database
        $stmt = $con->prepare("SELECT 
                                    UserID,Username,Password 
                               FROM 
                                    users 
                               WHERE 
                                    Username=?
                               AND 
                                    Password = ? 
                               AND 
                                    GroupID = '1'
                               LIMIT 1");
        $stmt->execute(array($username,$hashedPass));
        $row= $stmt->fetch(); // row get the data in array
        $count = $stmt->rowCount();

        // If count > 0 this mean the database contain record about this username
        if($count > 0){
        $_SESSION['username']=$username;  //Register session Name
        $_SESSION['ID'] = $row['UserID']; //Register session id
        header('location: dashboard.php'); // Redirect to dashboard page
        exit();
      }



    }

    ?>

    
   
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <h4 class="text-center">Login</h4>
        <input class="form-control" type="text" name ='user' placeholder="Username" autocomplete="off">
        <input class="form-control" type="password" name='pass' placeholder="password" autocomplete='new-password'><!--autocomplete special for chrome in order not to complete the password--> 
        <input class="btn btn-primary btn-block" type="submit" value="Login">
    </form>



    
 


<?php include $tp1 . "footer.php"; ?>


