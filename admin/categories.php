<?php

/*
  Template Page
*/

ob_start(); // Output Buffering Start

session_start();

#$noNavbar='';
$pageTitle="Categories";
if(isset($_SESSION['username'])){  

    include 'init.php';
    include "navbar.php";

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // Start Manage Page
        if ($do=='Manage') {//manage page 

            $sort ='ASC';
            $sort_array = array('ASC','DESC');
            if(isset($_GET['sort'])&& in_array($_GET['sort'],$sort_array) ){
                $sort=$_GET['sort'];
            }



            $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
            $stmt2->execute();
            $cats = $stmt2->fetchAll();?>
            <h1 class="text-center">Manage Categories</h1>
            <div class="container categories">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Manage Categories
                        <div class="ordering pull-right">
                            Ordering:
                            <a class="<?php if($sort=='ASC') { echo 'active';}?> " href="?sort=ASC">ASC</a>
                            <a class="<?php if($sort=='DESC') { echo 'active';}?> "href="?sort=DESC">DESC</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php 
                            foreach($cats as $cat){
                                echo "<div class='cat'>";
                                    echo "<div class='hidden-buttons'>";
                                        echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                                        echo "<a href='#' class='btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                                    echo "</div>";
                                    echo "<h3>" . $cat['Name']."</h3>";
                                    echo "<p>"; if($cat['Description']==''){echo 'This is empty';}else{echo $cat['Description'];}echo "</p>";
                                    echo '<span>Ordering is ' . $cat['Ordering'] . '</span>';
                                    if($cat['Visibility']==1){echo '<span class="visibility">Hidden</span>';}   
                                    if($cat['Allow_Comment']==1){echo '<span class="commenting">Comment Disabled</span>';} 
                                    if($cat['Allow_Ads']==1){echo '<span class="Advertises">Ads Disabled</span>';} 
                                echo "</div>";
                                echo "<hr>";
                            }
                        ?>
                    </div>
                </div>
            
            </div>

        <?php    
        }elseif($do == 'Add'){?>
            
            
            <h1 class="container">Add New Categories</h1>
            <div class="container">
                <form class="form-horizantal" action="?do=Insert" method="POST">
                    <!--Start Name field-->
                    <div class="form-group form-group-lg" >
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="clo-sm-10 col-md-4">
                                <input type="text" name="name" class="form-control" autocomplete="off"   placeholder="The name of category"/>
                        </div>
                    </div>
                    <!--End Name field-->

                    <!--Start Description field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="clo-sm-10 col-md-4">
                                <input type="text" name="description" class=" form-control"  placeholder="Describe the category"/>
                                
                        </div>
                    </div>
                    <!--End Description field-->

                    <!--Start ordering field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <div class="clo-sm-10 col-md-4">
                                <input type="text" name="ordering" class="form-control"  placeholder="Number to arrange the categories"/>
                        </div>
                    </div>
                    <!--End ordering field-->

                    <!--Start Visibility field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Fullname</label>
                        <div class="clo-sm-10 col-md-4">
                                <input type="Fullname" name="Fullname" class="form-control"  placeholder="Full Name Appear in Your Profile"/>
                        </div>
                    </div>
                    <!--End Visibility field-->

                    <!--Start submit field-->
                    <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">visibility</label>
                        <div class="clo-sm-offset-2 col-sm-10">
                            <div>
                                <input id="vis-yes" type="radio" name="visibility" value="0" checked/>
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                            <input id="vis-no" type="radio" name="visibility" value="1" />
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!--End submit field-->

                     <!--Start commenting field-->
                     <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Allow Commenting</label>

                        <div class="clo-sm-offset-2 col-sm-10">
                            <div>
                                <input id="com-yes" type="radio" name="commenting" value="0" checked/>
                                <label for="com-yes">Yes</label>
                            </div>
                            <div>
                            <input id="com-no" type="radio" name="commenting" value="1" />
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!--End commenting field-->

                     <!--Start ads field-->
                     <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Allow Adds</label>

                        <div class="clo-sm-offset-2 col-sm-10">
                            <div>
                                <input id="ads-yes" type="radio" name="ads" value="0" checked/>
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                            <input id="ads-no" type="radio" name="ads" value="1" />
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!--End ads field-->

                    <!--Start submit field-->
                    <div class="form-group form-group-lg">
                        <div class="clo-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Category" class="btn btn-primary btn-lg" required="required"/>
                        </div>
                    </div>
                    <!--End submit field-->

                </form>
                
            </div> 


  <?php }elseif($do == 'Insert'){

        
            if ($_SERVER['REQUEST_METHOD']=='POST'){

                echo "<h1 class='text-center'>Insert Category</h1>";

                echo "<div class='container'>";

                //Get variables from the form
                
                $name    = $_POST['name'];
                $desc    = $_POST['description'];
                $order   = $_POST['ordering'];
                $visible = $_POST['visibility'];
                $comment = $_POST['commenting'];
                $ads     = $_POST['ads'];
 
               // Check If Category Exist in Database

                $check = checkItem("Name","categories ",$name);
                if($check==1) {
                    $theMsg = "<div class='alert alert-danger'>Sorry this Category is exist</div>";
                    redirectHome($theMsg,'back');
                }else{

                    // Insert Category Info in database
                    $stmt = $con->prepare("INSERT INTO
                                            categories(Name,Description,Ordering,Visibility,Allow_Comment,Allow_Ads)
                                            VALUES(:zname, :zdesc, :zorder, :zvisible, :zcomment, :zads) ");
                    $stmt-> execute(array(
                            'zname'     => $name,
                            'zdesc'     => $desc,
                            'zorder'    => $order,
                            'zvisible'  => $visible,
                            'zcomment'  => $comment,
                            'zads'      => $ads

                    ));

                    // Echo success message
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted' . "</div>";

                    redirectHome($theMsg,'back');
                    }
        
                
               

            }else{
                echo "<div class='container'>";
                $theMsg = '<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
                redirectHome($theMsg,'back');
                echo "</div>";
            }
            
            echo "</div>";


        }elseif($do ==  'Edit'){
            //Check if Get request catid is numeric & get the integer value of it
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']):0;

            // Select All Data Depent On This ID
            $check = checkItem('userid','users',$userid);
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? ");

            // Execute Query
            $stmt->execute(array($catid));

            // Fetch The Data
            $cat= $stmt->fetch(); // row get the data in array

            // The Row Count
            $count = $stmt->rowCount();

            // If there's such ID show the form

            if ($count>0) { ?>

                GOOOOOOOOOOOd
            <?php 

            // If there's no shuch ID show Error Message   
            }else{

                echo "<div class='container'>";
                $theMsg = '<div class="alert alert-danger">Theres no such ID</div>';
                redirectHome($theMsg);
                echo "</div>";
            }

                    }elseif($do ==  'Update'){
                    
                    
                    }elseif($do ==  'Delete'){


                    }

                    include $tp1 . 'footer.php';

                }else {
                    header('Location: index.php');
                    exit();
                }
                ob_end_flush();

            ?>
                    
