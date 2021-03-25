<?php

/* Categories => [Manage | Edit  Update |Add | Insert | Delete | States]*/

$do = '';                   /*Or you can write if statement like to this: 
                            $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; */
if(isset($_GET['do'])){
    $do = $_GET['do'];
    
}else{
    $do = 'Manage';
}

if($do=='Manage'){
    echo "welcom you are in manage category page ";
    echo '<a href="?do=insert">Add New Categry +</a>';

}elseif($do == 'Add'){
    echo "welcome you are in add category page";

}elseif($do == 'Insert'){
    echo "welcome you are in insert category page";

}else{
    echo 'Erro ther\'s no page with this name';
}