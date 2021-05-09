<?php
// Items Page

ob_start();

session_start();

$pageTitle = 'Items';
include 'init.php';
include "navbar.php";
if (isset($_SESSION['username'])) {

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage'){

        echo 'welcom thamer in manage page';

    }elseif($do == 'Add'){?>
        
        <h1 class="text-center">Add New Item</h1>
        <div class="container">
            <form class="form-horizantal" action="?do=Insert" method="POST">
                <!--Start Name field-->
                <div class="form-group form-group-lg" >
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="clo-sm-10 col-md-4">
                            <input type="text"
                                    name="name"
                                    class="form-control"
                                    required='required'
                                    placeholder="The name of item"/>
                    </div>
                </div>
                <!--End Name field-->

                <!--Start Name field-->
                <div class="form-group form-group-lg" >
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="clo-sm-10 col-md-4">
                            <input type="text"
                                    name="description"
                                    class="form-control"
                                    required='required'
                                    placeholder="The name of description"/>
                    </div>
                </div>
                <!--End Name field-->

                <!--Start Name field-->
                <div class="form-group form-group-lg" >
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="clo-sm-10 col-md-4">
                            <input type="text"
                                    name="price"
                                    class="form-control"
                                    required='required'
                                    placeholder="Price"/>
                    </div>
                </div>
                <!--End Name field-->

                <!--Start Name field-->
                <div class="form-group form-group-lg" >
                    <label class="col-sm-2 control-label">Country</label>
                    <div class="clo-sm-10 col-md-4">
                            <input type="text"
                                    name="contry"
                                    class="form-control"
                                    required='required'
                                    placeholder="countrt of made"/>
                    </div>
                </div>
                <!--End Name field-->

                <!--Start status field-->
                <div class="form-group form-group-lg" >
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="clo-sm-10 col-md-4">
                            <select class="form-control" name="status" >
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="1">Very Old</option>
                            </select>
                    </div>
                </div>
                <!--End Name field-->

                <!--Start submit field-->
                <div class="form-group form-group-lg">
                    <div class="clo-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Item" class="btn btn-primary btn-sm" required="required"/>
                    </div>
                </div>
                <!--End submit field-->

            </form>
            
        </div> 

    <?php
    }elseif($do == 'Insert'){
        echo 'Insert page';

    }elseif($do == 'Edit'){
        echo 'Edit page';

    }elseif($do == 'Update'){
        echo 'Update page';

    }elseif($do == 'Delete'){
        echo 'Delete page';

    }elseif($do == 'Approve'){
        echo 'Update page';

    }

    include $tp1 . 'footer.php';
}else {
 
    header('location: index.php');
    exit();
}


?>


