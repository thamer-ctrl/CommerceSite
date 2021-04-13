<?php 
    
    /*
    ** Title function v1.0
    ** Title function that echo the page title in case the page
    ** has the variable $pageTitle and echo default title for other pages
    */

    function getTitle(){

        global $pageTitle;

        if (isset($pageTitle)){

            echo $pageTitle;

        }else{

            echo 'Default';
            
        }
    }


    /*
    **  Home Redirect function v2.0 [This function accept parameters]
    **  $theMsg = Echo the message
    **  $seconds = seconds before redirecting  
    */


    function redirectHome($theMsg,$url=NULL ,$seconds = 3){

        
        if ($url==NULL) {
            $url="index.php";
        }else{
            $url=isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=='' ? $_SERVER['HTTP_REFERER'] : 'index.php';
        }  
        
        echo $theMsg;

        echo "<div class='alert alert-info'>You will be redirected to $url after $seconds Seconds .</div>";

        header("refresh:$seconds;url=$url");

        exit(); //after header you must add exit()


    }


/*
** Check items function v1.0
** Function to check item in database [function accept parameters]
** $select = the item to select [example: user,item]
** $from = the table to select from [example: users,items]
** $vlaue = the value of select [example: Thamer,Box]
*/

function checkItem($selct,$from,$value){

    global $con; // global is important 

    $statement = $con->prepare("SELECT $selct FROM $from WHERE $selct = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count;
}

function countItems($item,$table){
    global $con;
    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
    $stmt2 -> execute();
    return $stmt2->fetchColumn();
}

/*
** Get latest records function v1.0
** Function to get latest items from database [Users, Items, Comments] 
** $select  = field to select
** $table = the table to choose from
** $limit = number of records to get 
*/

function getLatest($selct,$table,$order,$limit=5){
global $con;
$getStmt = $con->prepare("SELECT $selct FROM $table ORDER BY $order DESC LIMIT $limit");
$getStmt->execute();
$row = $getStmt->fetchAll();
return $row;
}
















//**************Garbage *******************/


  /*
    **  Home Redirect function v1.0 [This function accept parameters]
    **  $errorMsg = Echo the error message
    **  $seconds = seconds before redirecting  
    


    function redirectHome($errorMsg, $seconds = 3){

        echo "<div class='alert alert-danger'>$errorMsg</div>";

        echo "<div class='alert alert-info'>You will be redirected to homepage after $seconds Seconds .</div>";

        header("refresh:$seconds;url=index.php");

        exit(); //after header you must add exit()


    }*/